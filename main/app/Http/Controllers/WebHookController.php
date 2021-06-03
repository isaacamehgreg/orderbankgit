<?php

namespace App\Http\Controllers;

use App\Models\PaystackTransfer;
use App\Wallet;
use App\WalletUsages;
use Illuminate\Http\Request;

class WebHookController extends Controller
{
    public function webhook() {

        if ((strtoupper($_SERVER['REQUEST_METHOD']) != 'POST' ) || !array_key_exists('HTTP_X_PAYSTACK_SIGNATURE', $_SERVER) ) {
            // only a post with paystack signature header gets our attention
            exit();
        }

        // Retrieve the request's body
        $input = @file_get_contents("php://input");

        if(!$_SERVER['HTTP_X_PAYSTACK_SIGNATURE'] || ($_SERVER['HTTP_X_PAYSTACK_SIGNATURE'] !== hash_hmac('sha512', $input, env('PAYSTACK_SECRET_KEY')))){
          // silently forget this ever happened
          exit();
        }


        http_response_code(200);

        // parse event (which is json string) as object
        // Do something - that will not take long - with $event
        $event = json_decode($input);
        switch($event->event){

            // charge.success
            case 'charge.success':
                    $txn = $event;
                    $ref = $event->reference;
                    $this->walletFunding($txn, $ref);
                break;

            case 'transfer.success':
                $this->transfer_success($event->data);
                break;
            case 'transfer.failed':
                $this->transfer_failed($event->data);
                break;

            case 'subscription.disable':
            case 'subscription.create':
            case 'invoice.create':
            case 'invoice.update':
                break;

        }

        exit();
    }

    private function transfer_success($eventData) {
        $transfer = PaystackTransfer::where('transfer_code', $eventData->transfer_code)
            ->first();
        if ($transfer != null) {
            $walletUsage = WalletUsages::find($transfer->wallet_usage_id);
            $walletUsage->status = Wallet::STATUS_SUCCESSFUL;
            $walletUsage->save();

            $transfer->status = $eventData->status;
            $transfer->save();
        }
    }

    private function transfer_failed($eventData) {
        $transfer = PaystackTransfer::where('transfer_code', $eventData->transfer_code)
            ->first();
        if ($transfer != null) {
            $walletUsage = WalletUsages::find($transfer->wallet_usage_id);
            $walletUsage->status = "failed";
            $walletUsage->save();

            $transfer->status = $eventData->status;
            $transfer->save();
        }
    }

    public function walletFunding($txn, $reference) {
        try {

            $wallet_history = WalletHistory::where('reference', $reference)->first();

            if ($wallet_history->status == Wallet::STATUS_SUCCESSFUL) {
                return false;
            }

            $user = User::find($wallet_history->user_id);

            if('success' == $txn->data->status) {
                try {

                	$check =  Wallet::where('user_id', $user->id)->count();
                	if ($check == 0) {
                		$wallet = new Wallet();
                		$wallet->user_id = auth()->id();
                		$wallet->save();
                	}

                    $user = \auth()->user();

                    $wallet_history = WalletHistory::where('reference', $reference)->first();
                    $wallet_history->status = Wallet::STATUS_SUCCESSFUL;
                    $wallet_history->save();

                    $wallet =  Wallet::where('user_id', $user->id)->first();
                    $wallet->balance = ($wallet->balance + $wallet_history->amount);
                    $wallet->save();

                    // Send Mail
                   // Mail::to($user)->queue(new Subscribed($user, $plan));

                    // return redirect('/wallet')->with('success', 'Wallet funding successfully done.');
                    // return \response()->json(['status' => 'success']);

                    $message = "Your wallet has been funded with: N".$wallet_history->amount;

    				$this->sendRawMail($user->email, $message, 'Wallet Funding | OrderBank');
                }

                catch (\Exception $e) {
                    // return back()->with('error', 'An unknown Error Occurred.');
                    // return \response()->json(['status' => false, 'message' => $e->getMessage()]);
                }
            } else {
                // return back()->with('error', 'Failed to verify your payment.');
                // return \response()->json(['status' => false, 'message' => 'Status Not Success: '.$txn->data->status]);
            }
        } catch(\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
