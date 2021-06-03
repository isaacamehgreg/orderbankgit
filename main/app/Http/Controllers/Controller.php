<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Couriers;
use App\Areas;
use App\Recipients;
use App\States;
use App\Business;
use Validator;
use App\Orders;
use App\OrdersTracking;
use Auth;
use App\Customers;
use App\Products;
use \GuzzleHttp\Client;
use App\Http\Controllers\CronController;
use App\Forms;
use App\WhatsAppNumber;
use App\Wallet;
use App\MessageHistory;
use App\WalletUsages;
use App\User;
use App\Notifications;

use App\Mail\DefaultMailer;
use DB;

use Mail;
use Log;

ignore_user_abort(true);
set_time_limit(0);

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function only($user_role, $role = array()) {

    	if(!in_array($user_role, $role)) {
    		abort(404);
    	}
    }

     public function deduct($amount, $user_id = null) {

        $wallet = Wallet::where('user_id', $user_id ?? auth()->user()->id)->first();

        if (!$wallet) {
            $wallet = new Wallet();
            $wallet->user_id = auth()->id() ?? $user_id;
            $wallet->save();
        }

        if ($amount > $wallet->balance) {
            session()->flash('error', 'Insufficient Wallet Balance For SMS');
            return false;
        }

        $wallet->balance = ($wallet->balance - $amount);
        $wallet->save();

        return true;

	}

	public function credit($amount, $user_id) {

        $wallet = Wallet::where('user_id', $user_id)->first();

        if (!$wallet) {
            $wallet = new Wallet();
            $wallet->user_id = $user_id;
            $wallet->save();
        }

        $wallet->balance = ($wallet->balance + $amount);
        $wallet->save();

        return true;

    }

    public function wallet_use($paying, $amount, $user_id, $status = Wallet::STATUS_SUCCESSFUL) {
        $new = new WalletUsages();
        $new->user_id = $user_id;
        $new->paying_for = $paying;
        $new->amount = $amount;
        $new->status = $status;
        $new->save();
        return $new;
    }

    public function messageHistory($message, $channel, $user_id) {
        $new = new MessageHistory();
        $new->user_id = $user_id;
        $new->message = $message;
        $new->channel = $channel;
        $new->save();
    }

    public function getLocation(Request $request) {
    	$id = $request->location_id;
    	$courier = Couriers::find($id);

    	return response()->json($courier);
    }

    public function getAreas(Request $request) {
    	$id = $request->state_id;
    	$areas = Areas::where('state_id', $id)->get();

    	foreach($areas as $area) {
    		echo "<option value='".$area->id."'>".$area->title."</option>";
    	}
    }

    public function getArea(Request $request) {
    	$id = $request->area_id;
    	$area = Areas::where('id', $id)->get();

    	return response()->json($area);
    }

    public function getState(Request $request) {
    	$id = $request->state_id;
    	$state = States::where('id', $id)->get();

    	return response()->json($state);
    }

    public function getRecipient(Request $request) {
    	$id = $request->id;
    	$recipient = Recipients::find($id);

    	return response()->json($recipient);
    }

    public function addRecipient(Request $request) {
    	$response = '';
    	$data = $request->input('data');

    	$validator = Validator::make($request->all()['data'], [
    		'firstname' => 'required',
    		'lastname'  => 'required',
    		'phonenumber' => 'required',
    		'phonenumber_two' => 'nullable',
    		'state_id' => 'required',
    		'area_id' => 'required',
    		'address' => 'required'
     	]);

     	// dd($validator->errors());

     	if($validator->fails()) {

     		echo "<div class='alert alert-danger'>";

     		$messages = $validator->messages();

            foreach ($messages->all('<li>:message</li>') as $message)
            {
                echo $message;
            }

     		echo "</div>";

     	} else {

     		$recipient = new Recipients();
     		$recipient->firstname = $data['firstname'];
     		$recipient->lastname  = $data['lastname'];
     		$recipient->phonenumber = $data['phonenumber'];
     		$recipient->phonenumber_two = $data['phonenumber_two'];
     		$recipient->state_id = $data['state_id'];
     		$recipient->area_id = $data['area_id'];
     		$recipient->address = $data['address'];
     		$recipient->save();

     		return \response()->json(['success' => true, 'user' => Recipients::find($recipient->id)]);
     	}
    }


    public function editRecipient(Request $request) {
    	$response = '';
    	$data = $request->input('data');

    	$validator = Validator::make($request->all()['data'], [
    		'firstname' => 'required',
    		'lastname'  => 'required',
    		'phonenumber' => 'required',
    		'phonenumber_two' => 'nullable',
    		'state_id' => 'required',
    		'area_id' => 'required',
    		'address' => 'required'
     	]);

     	// dd($validator->errors());

     	if($validator->fails()) {

     		echo "<div class='alert alert-danger'>";

     		$messages = $validator->messages();

            foreach ($messages->all('<li>:message</li>') as $message)
            {
                echo $message;
            }

     		echo "</div>";

     	} else {

     		$recipient = Recipients::find($data['id']);
     		$recipient->firstname = $data['firstname'];
     		$recipient->lastname  = $data['lastname'];
     		$recipient->phonenumber = $data['phonenumber'];
     		$recipient->phonenumber_two = $data['phonenumber_two'];
     		$recipient->state_id = $data['state_id'];
     		$recipient->area_id = $data['area_id'];
     		$recipient->address = $data['address'];
     		$recipient->save();

     		return \response()->json(['success' => true, 'user' => Recipients::find($recipient->id)]);
     	}
    }

    public function tracking_status_add(Request $request) {
    	$response = '';
    	$data = $request->input('data');

    	$validator = Validator::make($request->all()['data'], [
    		'id' 						  => 'required',
    		'tracking_status'  			  => 'required',
    		'tracking_status_description' => 'nullable'
     	]);

     	// dd($validator->errors());

     	if($validator->fails()) {

     		echo "<div class='alert alert-danger'>";

     		$messages = $validator->messages();

            foreach ($messages->all('<li>:message</li>') as $message)
            {
                echo $message;
            }

     		echo "</div>";

     	} else {

     		$orders_edit = Orders::find($data['id']);
     		$orders_edit->delivery_status = $data['tracking_status'];
     		$orders_edit->order_shared_with = User::where('email_address', $data['share_to'])->first()->id;
     		$orders_edit->save();

     		$waybill_tracking = new OrdersTracking();
     		$waybill_tracking->order_invoice = $orders_edit->invoice;
     		$waybill_tracking->orders_id = $data['id'];
     		$waybill_tracking->status = $data['tracking_status'];
     		$waybill_tracking->desc = '';
     		$waybill_tracking->save();

            // get
            $order = Orders::find($data['id']);
            $order_invoice = $order->invoice;

            $customer = Customers::find($order->customer_id);

            $product = Products::find($order->product_id);

            $business = Business::where('user_id', $order->business_id)->first();

            $form = Forms::find($order->form_id);
            $whatsapp_device = WhatsAppNumber::find($form->whatsapp_number_id);

            \response()->json(['success' => true]);




            if($data['tracking_status'] == 'shipped') {
				$message = "".$customer->fullname.", your order ".$order_invoice." for ".$product->qty." ".$product->title." which cost NGN".number_format($product->price)." has been shipped. The order will be ".$order->delivery_time.". From: ".$business->business_phone_number." , ".$business->business_name."";
                        $this->sendSms($message, $customer->phonenumber, $customer->business_id);
				$this->sendRawMail($customer->email, $message, 'Update: Order #'.$order_invoice.' '.$data['tracking_status']);



            } elseif ($data['tracking_status'] == 'ready') {
			$message = "".$customer->fullname.", your order ".$order_invoice." for ".$product->qty." ".$product->title." which cost NGN".number_format($product->price)." is ready for delivery. Expect a call from the delivery person. From: ".$business->business_phone_number." , ".$business->business_name."";
                        $this->sendSms($message, $customer->phonenumber, $customer->business_id);
			$this->sendRawMail($customer->email, $message, 'Update: Order #'.$order_invoice.' '.$data['tracking_status']);



            } elseif ($data['tracking_status'] == 'delivered') {
                $message = "".$customer->fullname.", your order ".$order_invoice." for ".$product->qty." ".$product->title." which cost NGN".number_format($product->price)." has been delivered and receipt sent to your email. Thanks for your patronage. From: ".$business->business_phone_number." , ".$business->business_name."";
                $this->sendSms($message, $customer->phonenumber, $customer->business_id);


                $this->sendMail($customer->email, 'Receipt: #'.$order_invoice,
                    'forms.view_invoice', [
                    'order' => $order,
                    'customer' => $customer,
                    'product' => $product,
                    'business' => $business
                ]);


            } elseif ($data['tracking_status'] == 'cancelled') {
                $message = "".$customer->fullname.", It's sad to let you go. Your order ".$order_invoice." for ".$product->qty." ".$product->title." which cost NGN".number_format($product->price)." has been cancelled. If you still want it back, kindly call ".$business->business_phone_number." and we will be glad to deliver. From: ".$business->business_phone_number." , ".$business->business_name."";
                $this->sendSms($message, $customer->phonenumber, $customer->business_id);
				$this->sendRawMail($customer->email, $message, 'Update: Order # '.$order_invoice.' '.$data['tracking_status']);


            } elseif ($data['tracking_status'] == 'pending') {
                $message = "".$customer->fullname.", your order ".$order_invoice." is Pending. The order will be cancelled after 24hrs if no response is gotten from you, we are always at your service and ready to deliver your order. From: ".$business->business_phone_number." , ".$business->business_name."";
                        $this->sendSms($message, $customer->phonenumber, $customer->business_id);
				$this->sendRawMail($customer->email, $message, 'Update: Order # '.$order_invoice.' '.$data['tracking_status']);


            } elseif ($data['tracking_status'] == 'refunded') {
                $message = "".$customer->fullname.", your ".$order_invoice." for ".$product->qty." ".$product->title." which cost NGN".number_format($product->price)." has been refunded. From: ".$business->business_phone_number." , ".$business->business_name."";
                        $this->sendSms($message, $customer->phonenumber, $customer->business_id);
				$this->sendRawMail($customer->email, $message, 'Update: Order # '.$order_invoice.' '.$data['tracking_status']);


            }


     	}
    }

    public function sendSms($message, $number, $user_id = null) {

        $user = Business::where('user_id', $user_id)->first();
        $from = "OB App";

        $wallet = Wallet::where('user_id', $user_id)->first();

        $amount = '10';

        if (!$wallet) {
            $wallet = new Wallet();
            $wallet->user_id = $user_id;
            $wallet->save();
        }

         if ($wallet->balance == 0) {
            // do nothing
        } else {

        // file_get_contents('https://www.bulksmsnigeria.com/api/v1/sms/create?api_token=gyNouhREfzKfSzQeZm2rph6KlrZiBglIkWMEG6iOkeyvaBSnvHuNOt3JuLUP&from='.$from.'&to='.$number.'&body='.$message.'&dnd=4');
        // return true;

        $senderid = $from;
        $to = $number;
        $token = 'maKgF0RxFV6feLDImeKr3G5u8nFJDGZFyECuOaO7I9hgTNDAwt6aY6GEBfte';
        $baseurl = 'https://www.bulksmsnigeria.com/api/v1/sms/create?';

        $sms_array = array
          (
          'from' => $senderid,
          'to' => $to,
          'body' => $message,
          'dnd' => '4',
          'api_token' => $token
        );

        $params = http_build_query($sms_array);
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,$baseurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

        $response = curl_exec($ch);

        curl_close($ch);

        // echo $response; // response code

		$this->deduct($amount, $user_id);

		$this->wallet_use('SMS Charge', $amount, $user_id);

		$this->messageHistory($message, 'SMS', $user_id);

        return TRUE;

        }

    }

    public function delete_bulk(Request $request) {
        $response = '';
        $data = $request->input('data');

        $validator = Validator::make($request->all()['data'], [
            'id'                          => 'required'
        ]);


        if($validator->fails()) {

            echo "<div class='alert alert-danger'>";

            $messages = $validator->messages();

            foreach ($messages->all('<li>:message</li>') as $message)
            {
                echo $message;
            }

            echo "</div>";

        } else {

            $i = $data['id'];

            foreach($i as $ii) {
                Orders::find($ii)->delete();
            }

          //  $this->orderStatus($orders, $data['tracking_status'], @$data['remittedvalue']);

            return \response()->json(['success' => true]);
        }

    }

    public function tracking_status_add_bulk(Request $request) {
    	$response = '';
    	$data = $request->input('data');

    	$validator = Validator::make($request->all()['data'], [
    		'id' 						  => 'required',
    		'tracking_status'  			  => 'required',
    		'tracking_status_description' => 'nullable'
     	]);

     	// dd($validator->errors());


     	if($validator->fails()) {

     		echo "<div class='alert alert-danger'>";

     		$messages = $validator->messages();

            foreach ($messages->all('<li>:message</li>') as $message)
            {
                echo $message;
            }

     		echo "</div>";

     	} else {

	     	$i = $data['id'];
	     	$orders = [];
	     	foreach($i as $ii) {
		     	$orders[] = $ii;
	     	}

            $this->orderStatus($orders, $data['tracking_status'], @$data['remittedvalue']);

     		return \response()->json(['success' => true]);
     	}
    }

    public function sendMail($to, $subject = 'OrderBank', $view, $data, $user_id = null) {
        // $view_body = view($view, $data)->render();

        // $message = $view_body;
        // // Always set content-type when sending HTML email
        // $headers = "MIME-Version: 1.0" . "\r\n";
        // $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // // More headers
        // $headers .= 'From: <info@app.edenet.com.ng>' . "\r\n";

        // $mail = mail($to,$subject,$message,$headers);

        // return true;
        
        if(!$this->isValidEmail($to)) {
            return false;  
        }

        Mail::to($to)->send(new DefaultMailer(['to' => $to, 'subject' => $subject, 'view' => $view, 'data' => $data]));

        // $this->messageHistory($message, 'E-mail', $user_id);
	}
	
	public function isValidEmail(string $email) : bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
    
        return true;
    }

	public function sendRawMail($to, $message, $subject = 'OrderBank', $user_id = null) {

        if(empty($to)) {
            return false;
        }

        if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';

        $emailaddress = $to;

        if (preg_match($pattern, $emailaddress) === 0) {
            return false;
        }

        try {

            Mail::send([], [], function ($mail) use ($to, $subject, $message) {
                    $mail->to($to)
                    ->subject($subject)
                    ->from('support@orderbank.com.ng', 'OrderBank App')
                    ->setBody($message, 'text/html');
            });

        } catch(\Mailgun\Exception $e) {
            Log::error($e->getMessage());
        }
        $user_id = auth()->id();

        $this->messageHistory($message, 'E-mail', $user_id);
    }

    public function sendWhatsApp($message, $number, $device = '') {
/*
	    $curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.wassenger.com/v1/messages",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "{\"phone\":\"+234".$number."\",\"message\":\"".$message.".\"}",
		  CURLOPT_HTTPHEADER => array(
		    "content-type: application/json",
		    "token: 8d9a3a23fc68096c7cd3eaa9ad82a98548f273048ebd7a0728608e55fea4fc80df599691768d0e83"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  die( "cURL Error #:" . $err );
		}
*/

		// $data = [
		// 	'phone' => '+234'.$number,
		// 	'message' => $message,
  //           'device' => $device
		// ];

		// try {

		// 	$client = new Client([
		//     'headers' => ['Content-Type' => 'application/json', 'token' => '8d9a3a23fc68096c7cd3eaa9ad82a98548f273048ebd7a0728608e55fea4fc80df599691768d0e83']
		// ]);
		// $response = $client->post('https://api.wassenger.com/v1/messages',
		//         ['body' => json_encode($data)]
		// );
		// // $response = json_decode($response->getBody(), true);

		// return true;

		// } catch(\Exception $e) {

		// 	if($e instanceof \GuzzleHttp\Exception\ClientException ){
	 //        $response = $e->getResponse();
	 //        $responseBodyAsString = $response->getBody()->getContents();

	 //        }
		// 	report($e);
		// 	return false;

		// }

        return true;
    }


    public function orderStatus($orders, $status, $remit = null) {

	        foreach ($orders as $id) {
		        $orders_edit = Orders::find($id);
		 		$orders_edit->delivery_status = $status;
		 		// $orders_edit->remittedvalue = $remit;
		 		$orders_edit->save();

		 		$waybill_tracking = new OrdersTracking();
		 		$waybill_tracking->order_invoice = $orders_edit->invoice;
		 		$waybill_tracking->orders_id = $id;
		 		$waybill_tracking->status = $status;
		 		$waybill_tracking->desc = '';
		 		$waybill_tracking->save();

		 		$data['tracking_status'] = $status;
	        }

	 		// create task
		    $cron = new CronController();

		    $cron->createTasksBulkUpdateOrder($orders, $status);
     }

     public function sendmessage(Request $request) {
        $data = $request->all();

        $business = Business::where('user_id', $data['business_id'])->first();

	    $channel = $data['channel'];
	    $message = "Message From ".$business->business_name.": ".$data['message'];
        $order = Orders::find($data['order_id']);

        $customer = Customers::find($order->customer_id);

	    if ($channel == 'sms') {
		    $this->sendSms($message, $customer->phonenumber, $order->business_id);
	    } elseif ($channel == 'emailsms') {
            $this->sendSms($message, $customer->phonenumber, $order->business_id);
            $this->sendRawMail($customer->email, $message, "New Message From Order Bank");
	    } else {
		    $this->sendSms($message, $customer->phonenumber, $order->business_id);
            $this->sendRawMail($customer->email, $message, "New Message From Order Bank");
        }

	    echo "Sent";
     }

    public function sendBulkMessage(Request $request) {
        $data = $request->all();

        $business = Business::where('user_id', $data['business_id'])->first();

	    $status = $data['status'];
	    $allcustomers = $data['allcustomers'];
	    $channel = $data['channel'];
	    $message = "Message From ".$business->business_name.": ".$data['message'];
	    $users = [];
	    $from = [];

	    $orders = Orders::where('delivery_status', $status)->get();

	    if ($allcustomers == 'yes') {
		    $users[] = Customers::all();
	    } else {
		    foreach ($orders as $r) {
			    $users[] = Customers::find($r->customer_id);
		    }
	    }

	    if ($channel == 'sms') {
		    $from = ['sms' => 'yes'];
	    } elseif ($channel == 'emailsms') {
		    $from = ['emailsms' => 'yes'];
	    } else {
		    $from = ['all' => 'yes'];
	    }

	    // create task
	    $cron = new CronController();

	    $cron->createTasksBulkMessage($users, $message, $from);

	    echo "Sent to ". count($users) . " users";

    }

    public function message_history() {

        $user = auth()->user();
    
        $business_id = '';
        if ($user->role == 1) {
            $business_id = $user->id;
        } else {
            $business_id = $user->business_id;
        }

        $messages = MessageHistory::orderBy('created_at', 'DESC')->where('user_id', $business_id)->get();
        return view('message_history', ['messages' => $messages]);
    }

    public function checkBusinessEmail(Request $request) {
        $email = $request->email;

        $user = User::where('email_address', $email)->where('business_id', NULL)->count();

        if($user > 0) {
            echo 'success';
        } else {
            echo 'error';
        }
    }

    public function shareOrderDelivered(Request $request) {
        $id = $request->id;
        $value = '';

        $order = Orders::find($id);

        if($order->order_shared_delivered === 'yes') {
            $value = 'no';
        } else {
            $value = 'yes';
        }

        $order->order_shared_delivered = $value;
        $s = $order->save();

        $notif_business_owner = new Notifications();
        $notif_business_owner->user_id = $order->business_id;
        $notif_business_owner->content = 'An order you shared has been delivered';
        $notif_business_owner->link = url('orders?filter=shared');
        $notif_business_owner->save();

        $notif_shared_with = new Notifications();
        $notif_shared_with->user_id = $order->order_shared_with;
        $notif_shared_with->content = 'An order has been shared with you.';
        $notif_shared_with->link = url('orders?filter=shared');
        $notif_shared_with->save();

        if($s) {
            echo 'success';
        } else {
            echo 'error';
        }
    }

    public function delNotification(Request $request) {
        $notif = Notifications::find($request->id);
        $notif->delete();
    }

    public function clearNotifications($id) {

        $notif = Notifications::where('user_id', $id)->delete();

        return back()->with('success', 'Notifications cleared.');
    }
}
