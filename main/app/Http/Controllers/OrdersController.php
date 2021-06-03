<?php

namespace App\Http\Controllers;

use DB;
use App\Forms;
use Validator;
use App\Orders;
use App\User;
use App\Products;
use App\Customers;
use App\OrdersTracking;
use Illuminate\Http\Request;
use App\Http\Controllers\CronController;

class OrdersController extends Controller
{
    public function orders(Request $request) {

        $user = auth()->user();
        if ($user->role == 1) {
            if ($user->orders_count == 0 || $user->orders_count == NULL) {
                return redirect('/reports')->with('error', 'You have exceeded your order limit for this month. Kindly fund your wallet to upgrade your subscription.');
            }
        }

        $business_id = '';
        if ($user->role == 1) {
            $business_id = $user->id;
        } else {
            $business_id = $user->business_id;
        }

    	$filter = $request->get('filter');

    	if(empty($filter)) {
    		$orders = Orders::orderBy('created_at', 'DESC')->where('business_id', $business_id)->paginate(12);
    	} elseif ($filter == 'all') {
    		$orders = Orders::orderBy('created_at', 'DESC')->where('business_id', $business_id)->paginate(12);
    	} elseif ($filter == 'delivered') {
    		# code...
    		$orders = Orders::where('delivery_status', 'delivered')->orderBy('created_at', 'DESC')->where('business_id', $business_id)->paginate(12);
    	} elseif ($filter == 'new') {
	    	$orders = Orders::where('delivery_status', 'New Order')->orderBy('created_at', 'DESC')->where('business_id', $business_id)->paginate(12);
    	} elseif ($filter == 'shipped') {
    		$orders = Orders::where('delivery_status', 'shipped')->orderBy('created_at', 'DESC')->where('business_id', $business_id)->paginate(12);
    	} elseif ($filter == 'notshipped') {
    		$orders = Orders::where('delivery_status', 'notshipped')->orderBy('created_at', 'DESC')->where('business_id', $business_id)->paginate(12);
    	} elseif ($filter == 'cancelled') {
    		# code...
    		$orders = Orders::where('delivery_status', 'cancelled')->orderBy('created_at', 'DESC')->where('business_id', $business_id)->paginate(12);
    	} elseif ($filter == 'rescheduled') {
            # code...
            $orders = Orders::where('delivery_status', 'rescheduled')->orderBy('created_at', 'DESC')->where('business_id', $business_id)->paginate(12);
        } elseif ($filter == 'pending') {
            # code...
            $orders = Orders::where('delivery_status', 'pending')->orderBy('created_at', 'DESC')->where('business_id', $business_id)->paginate(12);
        } elseif ($filter == 'refunded') {
            # code...
            $orders = Orders::where('delivery_status', 'refunded')->orderBy('created_at', 'DESC')->where('business_id', $business_id)->paginate(12);
        } elseif ($filter == 'Ready For Delivery') {
	        $orders = Orders::where('delivery_status', 'Ready For Delivery')->orderBy('created_at', 'DESC')->where('business_id', $business_id)->paginate(12);
        } elseif ($filter == 'Payment Received') {
	        $orders = Orders::where('delivery_status', 'Payment Received')->orderBy('created_at', 'DESC')->where('business_id', $business_id)->paginate(12);
        } elseif ($filter == 'failed') {
	        $orders = Orders::where('delivery_status', 'failed')->orderBy('created_at', 'DESC')->where('business_id', $business_id)->paginate(12);
        } elseif ($filter == 'deleted') {
            $orders = Orders::where('delivery_status', 'deleted')->orderBy('created_at', 'DESC')->where('business_id', $business_id)->paginate(12);
        } elseif ($filter == 'followup') {
            $orders = Orders::where('delivery_status', 'followup')->orderBy('created_at', 'DESC')->where('business_id', $business_id)->paginate(12);
        } elseif ($filter == 'shared') {
            $orders = Orders::where('delivery_status', 'shared')->orderBy('created_at', 'DESC')->where('business_id', $business_id)->orWhere('order_shared_with', $business_id)->paginate(12);
        }

        if($request->daterange) {
	        $filter = explode(" ", $request->daterange);

    		$start_date = date('Y-m-d', strtotime($filter[0]));
    		$end_date = date('Y-m-d', strtotime($filter[2]));

    		$orders = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('business_id', $business_id)->paginate(12);
        }

        if($request->order) {
    		$orders = Orders::where('invoice', '=', $request->order)->where('business_id', $business_id)->paginate(12);
        }

    	return view('orders.index', ['orders' => $orders]);
    }

    public function delete_orders($id) {
        $order = Orders::find($id);
        $order->delete();

        return back()->with('success', 'Deleted');
    }

    public function edit_orders_get($id) {

	    $order = Orders::findOrFail($id);

	    // check if order has form id
	    $check_form_id = Forms::find($order->form_id);
	    if(is_null($check_form_id)) {
		    return redirect('/orders/edit/choose_form/'.$id);
	    }

	    $customer = Customers::findOrFail($order->customer_id);
	    $product = Products::find($order->product_id);
	    $form = Forms::find($order->form_id);

	    return view('orders.edit', ['order' => $order, 'customer' => $customer, 'product' => $product, 'form' => $form]);
    }

    public function edit_orders_post(Request $request, $id) {
	    $order = Orders::findOrFail($id);
	    $customer = Customers::findOrFail($order->customer_id);

		$validator = Validator::make($request->all(), [
            'fullname'  => 'required',
            'address' => 'required',
            'state' => 'required',
            'delivery_time' => 'required',
            'phonenumber' => 'required|digits:11',
            'phonenumbertwo' => 'nullable|digits:11',
            'email' => 'nullable',
            'product' => 'required',
            'product_qty' => 'required',
            'product_total_price' => 'required',
            'delivery_time' => 'required'
        ]);

        $data = $request->all();

        if($validator->fails()) {

            return back()->withErrors($validator);

        } else {


            // Edit Customer
            $customer = Customers::find($customer->id);
            $customer->fullname = $data['fullname'];
            $customer->address = $data['address'];
            $customer->state = $data['state'];
            $customer->phonenumber = $data['phonenumber'];
            $customer->email = $data['email'];
            $customer->phonenumber_two = $data['phonenumbertwo'];
            $customer->save();

            $order = Orders::find($id);
            $order->customer_id = $customer->id;
            $order->delivery_time = $data['delivery_time'];
            $order->product_id = $data['product'];
            $order->product_qty = $data['product_qty'];
            $order->product_total_price = preg_replace('/\D/', '', $data['product_total_price']);
            $order->delivery_time = $data['delivery_time'];
            $order->save();


            return back()->with('success', 'Order modified');

        }
    }

    public function choose_form_get($id) {
	    $order = Orders::find($id);
	    $forms = Forms::all();

	    return view('orders.choose_form', ['order' => $order, 'forms' => $forms]);
    }

    public function choose_form_post(Request $request, $id) {
	    $order = Orders::find($id);
	    $forms = Forms::all();

	    $validator = Validator::make($request->all(), [
		   'form' => 'required'
	    ]);

	    if($validator->fails()) {
		    return back()->withErrors($validator);
	    } else {
		    $order_edit = Orders::find($id);
		    $order_edit->form_id = $request->form;
		    $order_edit->save();

		    return redirect('/orders/edit/'.$id)->with('success', 'You can now edit this order');
	    }
    }

    public function comment_order(Request $request) {
	    $validator = Validator::make($request->all(), [
		   'order_id' => 'required',
		   'comment'  => 'nullable'
	    ]);

	    if($validator->fails()) {
		    return back()->withErrors($validator);
	    } else {
		    $id = $request->order_id;
		    $order = Orders::find($id);
		    $order->comment = $request->comment;
		    $order->save();

		    return back()->with('success', 'Comment successful');
	    }
    }

    public function newOrder() {
        return view('orders.new');
    }

    public function newOrderPost(Request $request) {
        $request->validate([
            'fullname' => 'required',
            'phone_number' => 'required',
            'phone_number_two' => 'nullable',
            'full_address' => 'required',
            'state' => 'required',
            'email_address' => 'required',
            'qty' => 'required',
            'product_name' => 'required',
            'price' => 'required',
            'delivery_time' => 'required'
        ]);

        $user = '';
        if (auth()->user()->role != 1) {
            $user = User::find(auth()->user()->business_id)->id;
        } else {
            $user = auth()->user()->id;
        }

        $fullname = $request->fullname;
        $phone_number = $request->phone_number;
        $phone_number_two = $request->phone_number_two;
        $full_address = $request->full_address;
        $state = $request->state;
        $email_address = $request->email_address;
        $qty = $request->qty;
        $product_name = $request->product_name;
        $price = $request->price;
        $delivery_time = $request->delivery_time;

        // create customer
        $customer = new Customers();
        $customer->business_id = $user;
        $customer->fullname = $fullname;
        $customer->address = $full_address;
        $customer->state = $state;
        $customer->phonenumber = $phone_number;
        $customer->email = str_replace(' ', '', $email_address);
        $customer->phonenumber_two = $phone_number_two;
        $customer->save();

        // create product
        $products = new Products();
        $products->business_id = $user;
        $products->title = $product_name;
        $products->qty = $qty;
        $products->price = $price;
        $products->save();

        $invoice_number = strtoupper("".rand(10000, 50000));

        $order = new Orders();
        $order->business_id = $user;
        $order->invoice = $invoice_number;
        $order->sender = 'ORDERBANK';
        $order->customer_id = $customer->id;
        $order->form_id = 0;
        $order->delivery_status = 'New Order';
        $order->delivery_time = $delivery_time;
        $order->product_id = $products->id;
        $order->product_qty = $qty;
        $order->product_total_price = $price;
        $order->save();

        $order_tracking = new OrdersTracking();
        $order_tracking->business_id = $user;
        $order_tracking->orders_id = $order->id;
        $order_tracking->order_invoice = $invoice_number;
        $order_tracking->status = 'New Order';
        $order_tracking->desc = 'Order has been generated';
        $order_tracking->save();

        // create task
        $cron = new CronController();

        $task_data = [
            'order_id' => $order->id,
            'fullname' => $fullname,
            'phonenumber' => $phone_number,
            'product_qty' => $qty,
            'product_title' => $products->title,
            'product_price' => $products->price,
            'invoice_number' => $invoice_number,
            'time' => $delivery_time,
            'form_id' => 0
        ];

        $cron->createTasksNewOrder($task_data);

        return back()->with('success', 'New Order Created.');
    }
}
