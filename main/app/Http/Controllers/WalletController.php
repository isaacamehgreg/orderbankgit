<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\{Helpers\Banks,
    Models\BankDetails,
    Models\PaystackTransfer,
    Models\ReferralEarning,
    WalletHistory,
    Wallet,
    WalletUsages};

class WalletController extends Controller
{
    public function index() {
    	$wallet_history = WalletHistory::where('user_id', auth()->id())->get();
    	return view('wallet.index', ['wallet_history' => $wallet_history]);
    }

    public function fund() {
    	return view('wallet.fund');
    }

    public function fundPost(Request $request) {
    	$user = $request->user;
        $amount = $request->amount;
        $type = $request->type;
        $reference = str_random(12);

        $wallet_history = new WalletHistory();
        $wallet_history->user_id = $user;
        $wallet_history->amount = $amount;
        $wallet_history->status = 'Pending/Failed';
        $wallet_history->reference = $reference;
        $wallet_history->type = $type;
        $wallet_history->save();

        return $reference;
    }

    public function verifyPayment($reference) {
        if (!$reference) {
            return back()->with('error', 'No/invalid transaction reference was provided');

            // return \response()->json(['status' => false, 'message' => 'No/invalid transaction reference was provided']);
        }

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . $reference,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "authorization: Bearer " . env('PAYSTACK_SECRET_KEY'),
                "cache-control: no-cache"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if ($err) {
            return back()->with('error', 'Could not communicate with payment gateway, please try again later.');
        }

        $txn = json_decode($response);

        if ($txn->status == false) {
            return back()->with('error', 'Transaction reference not found. Try again');
           // return \response()->json(['status' => false, 'message' => 'Transaction reference not found']);
        }

        $user = \request()->user();

        // dd($txn);

        if('success' == $txn->data->status) {
            try {

            	$check =  Wallet::where('user_id', $user->id)->count();
            	if ($check == 0) {
            		$wallet = new Wallet();
            		$wallet->user_id = auth()->id();
            		$wallet->save();
            	}

                $user = \auth()->user();
                $wallet_history = WalletHistory::where([
                    'reference' => $reference,
                    'user_id' => $user->id
                ])->first();

                // check again to ensure to avoid double crediting
                if ($wallet_history->status == Wallet::STATUS_SUCCESSFUL ||
                    $wallet_history == "paid") {
                    return redirect('/wallet')->with('success', 'Your wallet was credited.');
                }
                $wallet_history->status = Wallet::STATUS_SUCCESSFUL;
                $wallet_history->save();

                $wallet =  Wallet::where('user_id', $user->id)->first();
                $wallet->balance = ($wallet->balance + $wallet_history->amount);
                $wallet->save();
                ReferralEarning::creditReferrer($user->id, $wallet_history);
                // Send Mail
               // Mail::to($user)->queue(new Subscribed($user, $plan));

                $message = "Your wallet has been funded with: N".$wallet_history->amount;
    			$this->sendRawMail($user->email_address, $message, 'Wallet Funding | OrderBank');
                return redirect('/wallet')->with('success', 'Wallet funding successfully done.');
            }
            catch (\Exception $e) {
                Log::error($e);
                return back()->with('error', 'An unknown Error Occurred: '.$e->getMessage());
            }
        } else {

            $wallet_history = WalletHistory::where('reference', $reference)->first();
            $wallet_history->status = 'unsuccessful';
            $wallet_history->save();

            return back()->with('error', 'Payment failed. Please make a new payment.');
        }
    }

    public function wallet_usage() {
        $usage = WalletUsages::orderBy('created_at', 'ASC')->where('user_id', auth()->id())->get();

        return view('wallet.usage', ['usage' => $usage]);
    }

    public function transfer() {
        return view('wallet.transfer');
    }

    public function transferPost(Request $request) {
        $validator = Validator::make($request->all(), [
            'account' => ['required'],
            'amount'  => ['required', 'numeric']
        ]);

        $validator->after(function($validator) use($request) {
           if ($request->account) {
               $id = $request->account;
               // check if it exists
               $user = User::where('id', $id)->orWhere('email_address', $id)->orWhere('business_phone_number', $id)->count();
               if ($user == 0) {
                   $validator->errors()->add('account', 'Account supplied does not exist or is invalid.');
               }
           }

           if ($request->amount) {

               $amount = $request->amount;

               if ($amount == 0) {
                    $validator->errors()->add('amount', 'Amount should be greater than 0.');
               }

               if ($amount < 100) {
                    $validator->errors()->add('amount', 'Amount should be greater than 100.');
               }

               // check if wallet has enough funds
               $wallet = auth()->user()->wallet();

               if ($wallet == 100) {
                    $validator->errors()->add('amount', 'Insufficient Wallet Balance.');
               }

               if ($amount >= $wallet) {
                    $validator->errors()->add('amount', 'Insufficient Wallet Balance.');
               }
           }
        });

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $account = $request->account;
        $amount = $request->amount;

        $user = User::where('id', $account)->orWhere('email_address', $account)->orWhere('business_phone_number', $account)->first();

        if(!$user) {
            return back()->with('error', 'Account supplied does not exist.');
        }

        $this->deduct($amount);

        $this->sendRawMail(auth()->user()->email_address, 'Your Wallet Transfer Of N'.$amount.' has been sent to '.$user->email_address, 'Wallet Transfer Successfull');

        // credit
        $this->credit($amount, $user->id);

        // notif
        $this->sendRawMail($user->email_address, 'You just received a wallet transfer of N'.$amount.' from '.auth()->user()->email_address, 'Wallet Transfer Received.');

        $reference = str_random(12);

        // add history
        $this->wallet_use('Wallet Transfer to '.$user->email_address, $amount, auth()->id());

        $this->wallet_use('Wallet Funds Received', $amount, $user->id);

        return redirect('/wallet/usage')->with('success', 'Wallet Transfer Done.');

    }

    public function withdraw()
    {
        $bankInfo = auth()->user()->currentBankDetails();
        if ($bankInfo != null) {
            return view('wallet.withdraw', [
                'bank_name' => Banks::BANK_CODES[$bankInfo->bank_code]['name'],
                'account_number' => $bankInfo->nuban,
                'account_name' => $bankInfo->account_name
            ]);
        }
        return redirect('/profile')->with('error', "Set up your bank account details to withdraw");
    }

    public function withdrawPost(Request $request) {
        $user = auth()->user();
        $validation = Validator::make($request->all(), [
            'amount' => 'integer|required',
        ]);
        if ($validation->fails()) {
            return back()->withErrors($validation);
        }

        $savedBankInfo = $user->currentBankDetails();
        /*if ($savedBankInfo->nuban != $request->get('account_number')) {
            return back()->with('error', "Could not reconcile account details. Update your account info or contact support");
        }*/
        $checker = $this->checkDebitAmount($request->get('amount'), $user->wallet());
        if ($checker['status'] === false) {
            return back()->with('error', $checker['message']);
        }
        try {
            $amount = $request->get('amount');
            $this->deduct($amount);
            $usage = $this->wallet_use('Withdrawal from wallet', $amount, $user->id, "pending");
            $this->initiateTransfer($amount, $savedBankInfo->recipient_code, $usage->id);
            return back()->with('success', "Your transaction have been queued and will be processed shortly");
        } catch (\Exception $e) {
            Log::error($e);
            return back()->with('error', "Could not process your transaction at this time.");
        }
    }

    /**
     * Initiates a bank transfer using the PayStack API
     * @param $amount int amount to be transferred
     * @param $recipientCode string the user's recipient code. See https://paystack.com/docs/transfers/single-transfers#create-a-transfer-recipient
     * @param $walletHistoryId int ID of this transaction as recorded in the wallets_usage table
     * @throws \Exception
     */
    private function initiateTransfer($amount, $recipientCode, $walletHistoryId) {
        $url = "https://api.paystack.co/transfer";
        $body = http_build_query([
            "source" => "balance",
            "amount" => $amount,
            "recipient" => $recipientCode,
            "reason" => "Withdrawal from wallet"
        ]);
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer " . env("PAYSTACK_SECRET_KEY"),
            "Cache-Control: no-cache",
        ));
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $err = curl_error($ch);
        if ($err) {
            Log::error($err);
            $this->refundUser(auth()->user()->id, $amount);
            throw new \Exception("failed to communicate with payment gateway");
        }
        $txnDetails = json_decode($response);
        Log::info(json_encode($txnDetails, JSON_PRETTY_PRINT));
        if (!$txnDetails->status) {
            $this->refundUser(auth()->user()->id, $amount);
        }
        PaystackTransfer::create([
            'user_id' => auth()->user()->id,
            'wallet_usage_id' => $walletHistoryId,
            'reference' => $txnDetails->data->reference,
            'status' => $txnDetails->data->status,
            'transfer_code' => $txnDetails->data->transfer_code
        ]);
    }

    private function checkDebitAmount($amount, $currentBalance) {
        if ($amount === 0) {
            return [
                'status' => false,
                'message' => "Amount should be greater than ₦0"
            ];
        }

        if ($amount < 100) {
            return [
                'status' => false,
                'message' => "Amount should be greater than ₦100"
            ];
        }

        if ($amount >= $currentBalance) {
            return [
                'status' => false,
                'message' => "Insufficient balance in wallet"
            ];
        }
        return [
            'status' => true,
            'message' => ""
        ];
    }

    private function refundUser($userId, $amount) {
        // log the credit history
        $history = new WalletHistory();
        $history->user_id = $userId;
        $history->amount = $amount;
        $history->status = Wallet::STATUS_SUCCESSFUL;
        $history->reference = str_random(12);
        $history->gateway = 'Refund';
        $history->type = 'credit';
        $history->save();
        // update their balance
        $this->credit($amount, $userId);
    }
}
