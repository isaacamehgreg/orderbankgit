<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use App\Wallet;
use App\Subscriptions;
use App\Mail\Subscribed;
use Illuminate\Support\Str;
use App\BusinessSubscription;
use App\Mail\SubscriptionRenewed;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class SubscriptionController extends Controller
{
    public function subscription() {
        $subscriptions = Subscriptions::orderBy('id', 'ASC')->get();
        $reference = Str::random(24);
        $data = [
            'subscriptions' => $subscriptions,
            'reference' => $reference,
            'user' => \request()->user(),
            'business_subscription' => BusinessSubscription::where('user_id', \request()->user()->id)->first()
        ];
        return view('subscription.index', $data);

    }

    public function verifySubscriptionPayment($reference) {
        if (!$reference || !strpos($reference, "-")) {
            return $this->handlePaymentError("No/invalid transaction reference was provided");
        }
        $planTypeId = explode("-", $reference)[0];
        $planType = Subscriptions::find($planTypeId);
        
        Log::info($reference);

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
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
            Log::error($err);
            return $this->handlePaymentError("Could not establish connection to provider");
        }
        $txn = json_decode($response);
        if (!$txn->status) {
            Log::info($response);
            return $this->handlePaymentError("Payment provider encountered an error");
        }

        $amountPaid = (int) $txn->data->amount;

        $user = \request()->user();

        if ($user->trial() == 0) {
            $planPrice = (int) 100000;
        } else {
            $planPrice = (int) $planType->price * 100;
        }

        Log::info(json_encode($txn));
        
        $isAmountCorrect = ($amountPaid == $planPrice);
        if('success' == $txn->data->status && $isAmountCorrect) {
            try {

                $subscription = $this->subscribeUser($txn->data, $planTypeId);

                $plan = Subscriptions::find($planTypeId);

                $user = \auth()->user();
                // Send Mail
                //Mail::to($user)->queue(new Subscribed($user, $plan));

                Session::flash('message', "You have been successfully subscribed to the ".$plan->title);
                return redirect('/');
            }
            catch (\Exception $e) {
                Log::error($e);
                return $this->handlePaymentError("Could not subscribe you at the moment");
            }
        } else {
            return $this->handlePaymentError("Could not validate your payment. Please contact support");
        }
    }

    private function handlePaymentError($message)
    {
        $errors = new MessageBag(['error' => [$message]]);
        return redirect()->route('business-subscription')
            ->withErrors($errors);
    }

    private function subscribeUser($paystackData, $planTypeId) {
        $user = \request()->user();


        $plan = Subscriptions::find($planTypeId);
        $renewalDate = strtotime("+$plan->duration", time());

        BusinessSubscription::where('user_id', auth()->user()->id)->delete();

        $subscription = new BusinessSubscription([
            'business_id' => 0,
            'user_id' => auth()->user()->id,
            'subscription_id' => $planTypeId,
            'start_at' => time(),
            'end_at' => $renewalDate,
            'payload' => json_encode($paystackData)
        ]);

        $user_update = User::find($user->id);
        $user_update->orders_count = $plan->max_orders;
        $user_update->save();

        $subscription->save();
        return $subscription;
    }

    public function callbackEvent() {
        // only a post with paystack signature header gets our attention
        if ((strtoupper($_SERVER['REQUEST_METHOD']) != 'POST' ) || !array_key_exists('HTTP_X_PAYSTACK_SIGNATURE', $_SERVER) ) 
        exit();

        // Retrieve the request's body
        $input = @file_get_contents("php://input");

        // validate event do all at once to avoid timing attack
        if($_SERVER['HTTP_X_PAYSTACK_SIGNATURE'] !== hash_hmac('sha512', $input, env('PAYSTACK_SECRET_KEY')))
        exit();

        http_response_code(200);

        // parse event (which is json string) as object
        // Do something - that will not take long - with $event
        $event = json_decode($input);

        if('success' == $event->data->status) {

            $customer_email = $event->data->customer->email;
            $user = User::where('email_address', $customer_email)->first();

            $business_subscription = BusinessSubscription::where('account_id', $user->id)->first();

            $subscription = Subscriptions::find($business_subscription->subscription_id);

            $business_subscription->start_at = time();
            $business_subscription->end_at = strtotime("+$subscription->duration", time());
            $business_subscription->save();

            // subscription renewed mail.
            Mail::to($user)->queue(new SubscriptionRenewed($user, $subscription));
            
            // log this
            $log_event = new EventsPayload();
            $log_event->payload = json_encode($input);
            $log_event->business_subscription_id = $business_subscription->id;
            $log_event->save();

            Trials::where('user_id', auth()->user()->id)->update(['active' => 0])->save();
        }

        exit();
    }

    public function subscribeToActualPlan($subscription_id) {

        // $business_subscription = BusinessSubscription::find($subscription_id);
        // $user = User::find($business_subscription->user_id);
        // $customer = $user->email;
        // $subscription = Subscriptions::where('id', $business_subscription->subscription_id)->first();
        // $plan_code = $subscription->plan_code;
        // $startDate = $business_subscription->end_date;

        // $curl = curl_init();

        // $data = array("customer" => $customer, "plan" => $plan_code, "start_date" => $startDate);

        // $postdata = json_encode($data);

        // curl_setopt_array($curl, [
        //     CURLOPT_URL => "https://api.paystack.co/subscription",
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_SSL_VERIFYHOST => 0,
        //     CURLOPT_SSL_VERIFYPEER => 0,
        //     CURLOPT_POST => 1,
        //     CURLOPT_POSTFIELDS => $postdata,
        //     CURLOPT_RETURNTRANSFER => 1,
        //     CURLOPT_FOLLOWLOCATION => 1,
        //     CURLOPT_HTTPHEADER => [
        //         "accept: application/json",
        //         "authorization: Bearer " . env('PAYSTACK_SECRET_KEY'),
        //         "cache-control: no-cache"
        //     ],
        // ]);
        // $response = curl_exec($curl);
        // $err = curl_error($curl);

        // if ($err) {
        //     Log::error($err);
        //     return $this->handlePaymentError("Could not establish connection to provider");
        // }

        // $txn = json_decode($response);
        // if (!$txn->status) {
        //     Log::info($response);
        //     return $this->handlePaymentError("Payment provider encountered an error");
        // }

        // if('active' == $txn->data->status) {

        //     $business_subscription->payload = json_encode($response);
        //     $business_subscription->save();

        //     Trials::where('user_id', auth()->user()->id)->update(['active' => 0])->save();

        // } else {
        //     Log::alert($txn);
        //     return $this->handlePaymentError("Subscription failed.");
        // }

    }

    public function free() {
        $user = auth()->user();
        $plan = Subscriptions::where('price', '0.00')->first();
        // check if user already has this plan.
        $check = BusinessSubscription::where('user_id', $user->id)->where('subscription_id', $plan->id)->where('end_at', '<=', time())->first();

        if ($check) {
            return back()->with('success', 'Plan is already active');
        }
        
        // check if plan is active or not

        // if plan is active return back

        // if plan is not activate it..

        $renewalDate = strtotime("+$plan->duration", time());

        BusinessSubscription::where('user_id', auth()->user()->id)->delete();

        $subscription = new BusinessSubscription([
            'business_id' => 0,
            'user_id' => auth()->user()->id,
            'subscription_id' => $plan->id,
            'start_at' => time(),
            'end_at' => $renewalDate,
            'payload' => null
        ]);

        $subscription->save();
        
        $user_s = User::find(auth()->id());
        $user_s->orders_count = $plan->max_orders;
        $user_s->save();

        return back()->with('success', 'Plan is now active.');
    }

    public function upgrade($id) {
        $user = auth()->user();
        $plan = Subscriptions::find($id);
        // check if user already has this plan.
        $check = BusinessSubscription::where('user_id', $user->id)->where('subscription_id', $plan->id)->where('end_at', '<=', time())->first();

        if ($check) {
            return back()->with('success', 'Plan is already active');
        }
        
        // check if funds reach
        $wallet = Wallet::where('user_id', $user->id)->first();
        
        if ($plan->price > $wallet->balance) {
            return back()->with('error', 'Insufficient balance! Kindly top up.');
        }

        $renewalDate = strtotime("+$plan->duration", time());

        BusinessSubscription::where('user_id', auth()->user()->id)->delete();

        $subscription = new BusinessSubscription([
            'business_id' => 0,
            'user_id' => auth()->user()->id,
            'subscription_id' => $plan->id,
            'start_at' => time(),
            'end_at' => $renewalDate,
            'payload' => null
        ]);

        $subscription->save();
        
        $user_s = User::find(auth()->id());
        $user_s->orders_count = $plan->max_orders;
        $user_s->save();

        $wallet->balance = ($wallet->balance - $plan->price);
        $wallet->save();
        
        $this->wallet_use('Subscription Charge', $plan->price, auth()->user()->id);

        return back()->with('success', 'Plan is now active.');
    }
}
