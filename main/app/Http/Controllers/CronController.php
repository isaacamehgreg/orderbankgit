<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Crons;
use App\Orders;
use App\Products;
use App\Customers;
use App\Business;
use App\Forms;
use App\WhatsAppNumber;
use Mail;
use App\Mail\SendInvoice;
use App\Mail\DefaultMail;

class CronController extends Controller
{

    public function createTasksBulkMessage($users = [], $message, $channel = []) {

	    // build tasks
	    $tasks = ['users' => $users, 'message' => $message, 'channel' => $channel];

	    // store cron
	    $cron = new Crons();
	    $cron->type = 'bulkmessage';
	    $cron->tasks = json_encode($tasks);
	    $cron->executed = 0;
	    $cron->save();

	    return true;

    }

    public function runTaskBulkMessage() {
	    $cron = Crons::where('type', 'bulkmessage')->get();
	    $cron_count =  Crons::where('type', 'bulkmessage')->count();
	    $executed = 0;

	    if(count($cron) > 0) {

		    foreach ($cron as $cron) {

			    $data = json_decode($cron->tasks, true);
			    $users = $data['users'];
			    $message = $data['message'];
			    $channel = (isset($data['channel']) ? $data['channel'] : null);

				if(count($users) > 0) {
					foreach ($users as $index => $u) {
						$executed++;

						// dd($u);

						// $order = Orders::find($u['order_id']);
			            // $form = Forms::find($order->form_id);
            			$whatsapp_device = WhatsAppNumber::all()->first(); // find($form->whatsapp_number_id);

						if(isset($channel)) {
							if(@$channel['sms'] == 'yes' OR @$channel['all'] == 'yes') {

					    	    $this->sendSms($message, $u['phonenumber'], $u['business_id']);

						    }

						    if($channel['emailsnms'] == 'yes' OR $channel['all'] == 'yes') {

                                $this->sendRawMail($u['email'], $message, "New Broadcast Message From Order Bank");

					        }
						}

				        // remove sent messages
						unset($users[$index]);

						 // update list
						 $new_tasks = ['users' => $users, 'message' => $message];



                    }

                    $cron_update = Crons::find($cron->id);
                    $cron_update->delete();
				}
		    }

		    echo "Total crons for Bulk Message: ".$cron_count.", Tasks executed: ".$executed."<br>";

		}
    }

    public function createTasksBulkUpdateOrder($orders, $status) {
	    // build tasks
	    $tasks = ['orders' => $orders, 'status' => $status];

	    // store cron
	    $cron = new Crons();
	    $cron->type = 'bulkupdateorder';
	    $cron->tasks = json_encode($tasks);
	    $cron->executed = 0;
	    $cron->save();

	    return true;
    }

    public function runTasksBulkUpdateOrder() {

	    $cron = Crons::where('type', 'bulkupdateorder')->get();
	    $cron_count =  Crons::where('type', 'bulkupdateorder')->count();
	    $executed = 0;

	    echo "Total crons for Bulk Update Order: ".$cron_count."<br>";

	    if(count($cron) > 0) {

		    foreach ($cron as $cron) {

			    $data = json_decode($cron->tasks, true);
			    $orders = $data['orders'];
			    $status = $data['status'];

				foreach ($orders as $index => $u) {
					$executed++;

				    // get
					$order = Orders::find($u);

					if (!$order) {
						continue;
					}

			     //   if (is_null($order) OR $order == null) {
				    //     unset($orders[$index]);
				    //     continue;
			     //   }


			        if (count($orders) == 0) {
			            $cron_update = Crons::find($cron->id);
			            $cron_update->delete();
			            continue;
			        }

			        $order_invoice = $order->invoice;

			        $customer = Customers::find($order->customer_id);
			        $business = Business::where('user_id', $order->business_id)->first();

			        $product = Products::find($order->product_id);


			         $email = str_replace(' ', '', $customer->email);

$tracking_status = $data['status'];
 if($data['status'] == 'shipped') {
				$message = "".$customer->fullname.", your order ".$order_invoice." for ".$product->qty." ".$product->title." which cost NGN".$product->price." has been shipped. The order will be ".$order->delivery_time.". From: ".$business->business_phone_number." , ".$business->business_name."";
                        $this->sendSms($message, $customer->phonenumber, $customer->business_id);
                        $tracking_status = $data['status'];
				$this->sendRawMail($email, $message, "Update: $order_invoice $tracking_status");


            } elseif ($data['status'] == 'ready') {
                $tracking_status = $data['status'];
			$message = "".$customer->fullname.", your order ".$order_invoice." for ".$product->qty." ".$product->title." which cost NGN".$product->price." is ready for delivery. Expect a call from the delivery person. From: ".$business->business_phone_number." , ".$business->business_name."";
                        $this->sendSms($message, $customer->phonenumber, $customer->business_id);
			$this->sendRawMail($email, $message, "Update: $order_invoice $tracking_status");



            } elseif ($data['status'] == 'delivered') {
                $tracking_status = $data['status'];
                $message = "".$customer->fullname.", your order ".$order_invoice." for ".$product->qty." ".$product->title." which cost NGN".$product->price." has been delivered and receipt sent to your email. Thanks for your patronage. From: ".$business->business_phone_number." , ".$business->business_name."";
                $this->sendSms($message, $customer->phonenumber, $customer->business_id);


                $this->sendMail($email, 'Receipt: #'.$order_invoice,
                    'forms.view_invoice', [
                    'order' => $order,
                    'customer' => $customer,
                    'product' => $product,
                    'business' => $business
                ]);


            } elseif ($data['status'] == 'cancelled') {
                $message = "".$customer->fullname.", It's sad to let you go. Your order ".$order_invoice." for ".$product->qty." ".$product->title." which cost NGN".$product->price." has been cancelled. If you still want it back, kindly call ".$business->business_phone_number." and we will be glad to deliver. From: ".$business->business_phone_number." , ".$business->business_name."";
                $this->sendSms($message, $customer->phonenumber, $customer->business_id);
				$this->sendRawMail($email, $message, "Update: $order_invoice $tracking_status");


            } elseif ($data['status'] == 'pending') {
                $message = "".$customer->fullname.", your order ".$order_invoice." is Pending. The order will be cancelled after 24hrs if no response is gotten from you, we are always at your service and ready to deliver your order. From: ".$business->business_phone_number." , ".$business->business_name."";
                        $this->sendSms($message, $customer->phonenumber, $customer->business_id);
				$this->sendRawMail($email, $message, "Update: $order_invoice $tracking_status");


            } elseif ($data['status'] == 'refunded') {
                $message = "".$customer->fullname.", your ".$order_invoice." for ".$product->qty." ".$product->title." which cost NGN".$product->price." has been refunded. From: ".$business->business_phone_number." , ".$business->business_name."";
                        $this->sendSms($message, $customer->phonenumber, $customer->business_id);
				$this->sendRawMail($email, $message, "Update: $order_invoice $tracking_status");

		            }


			        // remove sent messages
					unset($orders[$index]);

					 // update list
					 $new_tasks = ['orders' => $orders, 'status' => $status];

					 $cron_update = Crons::find($cron->id);
					 if ($cron_update) {
					     $cron_update->delete();
					 }

		    	}

		    }



		}


    }

    public function createTasksNewOrder($tasks_data) {
	    // build tasks
	    $tasks = [$tasks_data];

	    // store cron
	    $cron = new Crons();
	    $cron->type = 'neworder';
	    $cron->tasks = json_encode($tasks);
	    $cron->executed = 0;
	    $cron->save();

	    return true;
    }

    public function runTasksNewOrder() {

	    $cron = Crons::where('type', 'neworder')->get();
	    $cron_count =  Crons::where('type', 'neworder')->count();
	    $executed = 0;

	    echo "Total crons for New Order: ".$cron_count."<br>";

	    if(count($cron) > 0) {

		    foreach ($cron as $cron) {



				if ($cron->executed == 1) {
				    continue;
				}

			    $data = json_decode($cron->tasks, true);

				if(count($data) > 0) {
					foreach ($data as $index => $u) {
						$executed++;

					    /*
			            $product_edit = Products::find($data['product']);
			            $product_edit->qty = $data['product_qty'] - $product->qty;
			            $product_edit->save();
						*/



						$order = Orders::find($u['order_id']);

						if(!$order) {
						    $cron_update = Crons::find($cron->id);
						    $cron_update->delete();
						}

						if (!isset($order->customer_id)) {
						    continue;
						}

						$order_invoice = $u['invoice_number'];
						$customer = Customers::find($order->customer_id);

            			$business = Business::where('user_id', $order->business_id)->first();

            			if (!$business) {
						    continue;
						}

			            $order_message = $u['fullname'].", you have successfully placed an order for ".$u['product_qty']." ".$u['product_title']." which cost NGN".$u['product_price'].". Order No. ".$u['invoice_number']." Thanks for ordering. From: ".$business->business_phone_number." , ".$business->business_name."";

						#".$u['time']."

			            // send sms
			            @$this->sendSms($order_message, $customer->phonenumber, $order->business_id);

			           try {
			                // send rawmail
			                $this->sendRawMail(str_replace(' ', '', $customer->email), $order_message, "Update: #$order_invoice New Order");
			           } catch(Exception $e) {
			               //
			           }

			            // send invoice
			            //dd($order);
			            $order = Orders::findOrFail($order->id);
			            $customer = Customers::find($customer->id);
			            $product = Products::find($order->product_id);
			         //   $this->sendMail($data['email'], 'New Order Invoice #'.$invoice_number,
			         //       'forms.view_invoice', [
			         //       'order' => $order,
			         //       'customer' => $customer,
			         //       'product' => $product
			         //   ]);

			            // $invoice_number = $order->invoice;

			            // $email = str_replace(' ', '', $customer->email);

			         //   Mail::to($email)->send(new SendInvoice(['to' => $email, 'subject' => 'New Order Invoice #'.$invoice_number, 'view' => 'forms.view_invoice', 'data' => [
			         //       'order' => $order,
			         //       'customer' => $customer,
			         //       'product' => $product,
			         //       'business' => $business
			         //   ]]));

				        // remove sent messages
						unset($data[$index]);

						 // update list
						 $new_tasks = $data;




                    }



				}

				$cron_update = Crons::find($cron->id);
				$cron_update->executed = 1;
				$cron_update->save();

				$cron_update = Crons::find($cron->id);
                $cron_update->delete();
		    }





		}



		return true;
    }

    public function fire() {
        $this->runTasksNewOrder();

         $this->runTasksBulkUpdateOrder();

         $this->runTaskBulkMessage();
    }

    public function cron_one() {
         $this->runTasksNewOrder();
        }

    public function cron_two() {

	     $this->runTasksBulkUpdateOrder();
    }
}
