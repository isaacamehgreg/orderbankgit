<?php

namespace App\Http\Controllers;

ignore_user_abort(true);
set_time_limit(0);

use Auth;
use App\User;
use App\Forms;
use Validator;
use App\Orders;
use App\Products;
use App\Customers;
use App\Business;
use App\DeliveryTimes;
use App\OrdersTracking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CronController;

class FormsController extends Controller
{
    public function index() {
        return view('forms.index', ['forms' => Forms::where('business_id', auth()->id())->get()]);
    }

    public function add_forms() {
        if(auth()->user()->isProfileComplete() == false) {
            return redirect('/profile')->with('error', 'Please fill in your profile before creating a form.');
        }

        if(auth()->user()->isBusinessProfileComplete() == false) {
            return redirect('/business')->with('error', 'Please fill in your business profile before creating a form.');
        }

    	return view('forms.create');
    }

    public function add_forms_post(Request $request) {
    	$validator = Validator::make($request->all(), [
    		'title' 	=> 'required',
    		'meta'  	=> 'nullable',
    		'products'	=> 'required',
    		'delivery_times' => 'required',
    		'link'		=> 'required|unique:forms',
            'redirect'  => 'nullable',
    	]);

    	if($validator->fails()) {
    		return back()->withErrors($validator);
    	} else {

    		$forms = new Forms();
            $forms->business_id = auth()->id();
    		$forms->title = $request->title;
    		$forms->products = json_encode($request->products);
    		$forms->delivery_times = json_encode($request->delivery_times);
    		$forms->link = $request->link;
            $forms->desc = $request->meta;
            $forms->redirect = $request->redirect;
            $forms->whatsapp_number_id = null;
            $forms->form_fields = json_encode($request->form_fields);
    		$forms->save();

    		return redirect('/forms')->with('success', 'Form created');

    	}
    }

    public function edit($id) {
        return view('forms.edit', ['form' => Forms::find($id)]);
    }

    public function editPost(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'title'     => 'required',
            'meta'      => 'nullable',
            'products'  => 'required',
            'link'      => 'required',
            'redirect'  => 'nullable',
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator);
        } else {

            $forms = Forms::Find($id);
            $forms->title = $request->title;
            $forms->products = json_encode($request->products);
            $forms->delivery_times = json_encode($request->delivery_times);
            $forms->link = $request->link;
            $forms->desc = $request->meta;
            $forms->redirect = $request->redirect;
            $forms->whatsapp_number_id = $request->whatsapp_device;
            $forms->form_fields = json_encode($request->form_fields);
            $forms->save();

            return back()->with('success', 'Form Modified');

        }
    }

    public function delete($id) {
        $form = Forms::find($id);
        $form->delete();

        return back()->with('success', 'Deleted');
    }


    public function viewForm($link) {
        $form = Forms::where('link', $link)->firstOrFail();

        $form->views = $form->views + 1;
        $form->save();

        return view('forms.view', ['form' => $form]);
    }

    public function viewFormPost(Request $request) {

        $validator = Validator::make($request->all()['data'], [
            'link' => 'required',
            'fullname'  => 'required',
            'address' => 'required',
            'state' => 'required',
            'delivery_time' => 'required',
            'phonenumber' => 'required|digits:11',
            'phonenumbertwo' => 'nullable|digits:11',
            'email' => array('nullable'),
            'product' => 'required',
            'product_qty' => 'required',
            'product_total_price' => 'required'
        ]);
        
        $validator->after(function($validator) use($request)
        {
            $data = $request->all()['data'];
            
            
            
        });

        $data = $request->all()['data'];
        
        $link = $data['link'];
        $form = Forms::where('link', $link)->firstOrFail();

        if($validator->fails()) {

            $m = null;
            $messages = $validator->messages();

            foreach ($messages->all('<li style="font-size: 15px; text-align: left; padding-bottom: 5px;">:message</li>') as $message)
            {
                $m .= $message;
            }

            $msg = "<div class='alert alert-danger'> ".$m."</div>";

            return \response()->json(['code' => 400, 'message' => $msg]);

        } else {

            // $user = User::where('id', $data['id'])->first();

            // if ($user->orders_count == 0 || $user->orders_count == NULL) {
            //     return \response()->json(['code' => 400, 'message' => 'This form is temporarily unavailable.', 'link' => $link]); 
            // }

            $invoice_number = strtoupper("".rand(10000, 50000));

            // Create Customer
            $customer = new Customers();
            $customer->business_id = $data['id'];
            $customer->fullname = $data['fullname'] ?? 'noname';
            $customer->address = $data['address'] ?? 'noaddress';
            $customer->state = $data['state'] ?? 'nostate';
            $customer->phonenumber = $data['phonenumber'] ?? 'nonumber';
            $customer->email = str_replace('gmail.con', 'gmail.com', str_replace(' ', '', $data['email'] ?? User::find($data['id'])->email_address));
            $customer->phonenumber_two = $data['phonenumbertwo'] ?? 'nonumber';
            $customer->save();
            
            
            // get delivery+time
            $dtime = DeliveryTimes::find($data['delivery_time']);

            $order = new Orders();
            $order->business_id = $data['id'];
            $order->invoice = $invoice_number;
            $order->sender = 'ORDERBANK';
            $order->customer_id = $customer->id;
            $order->form_id = $form->id;
            $order->delivery_status = 'New Order';
            $order->delivery_time = $dtime->value;
            $order->product_id = $data['product'];
            $order->product_qty = $data['product_qty'];
            $order->product_total_price = preg_replace('/\D/', '', $data['product_total_price']); 
            $order->save();

            $order_tracking = new OrdersTracking();
            $order_tracking->business_id = $data['id'];
            $order_tracking->orders_id = $order->id;
            $order_tracking->order_invoice = $invoice_number;
            $order_tracking->status = 'New Order';
            $order_tracking->desc = 'Order has been generated';
            $order_tracking->save();

            $u = User::where('id', $data['id'])->first();
            
            if ($u->subscription() <> 'Premium'):
                // take 1 order
                $user = User::where('id', $data['id'])->first();
                $user->orders_count = $u->orders_count - 1;
                $user->save();
            endif;

            $message = "
                Redirecting..
            ";
            
            $link = '';
            if($form->redirect == '') {
                $link = url('/view_invoice/'.$invoice_number.'/'.$order->id);
            } else {
                $link = $form->redirect;
            }

            $product = Products::find($data['product']);
            
            // create task
		    $cron = new CronController();
		    
		    $task_data = [
			    'order_id' => $order->id,
			    'fullname' => $data['fullname'],
			    'phonenumber' => substr($data['phonenumber'], 1),
			    'product_qty' => $data['product_qty'],
			    'product_title' => $product->title,
			    'product_price' => $product->price,
			    'invoice_number' => $invoice_number,
			    'time' => $dtime->value,
                'form_id' => $form->id
		    ];
		    
		    $cron->createTasksNewOrder($task_data);
            
            \session()->flash('success', 'Thank you for your order');
            return \response()->json(['code' => 200, 'message' => $message, 'link' => $link]);
        }
    }

    public function viewInvoice($link, $order_id) {
        $form = Forms::where('link', $link)->firstOrFail();
        $order = Orders::findOrFail($order_id);
        $customer = Customers::find($order->customer_id);
        $product = Products::find($order->product_id);
        $business = Business::where('user_id', $order->business_id)->first();

        return view('forms.view_invoice', ['form' => $form, 'order' => $order, 'customer' => $customer, 'product' => $product, 'business' => $business]);
    }

    public function viewInvoiceByInvoiceNumber($invoice, $order_id) {
        $order = Orders::findOrFail($order_id);
        $customer = Customers::find($order->customer_id);
        $product = Products::find($order->product_id);
        $business = Business::where('user_id', $order->business_id)->first();
        

        return view('forms.view_invoice', ['order' => $order, 'customer' => $customer, 'product' => $product, 'business' => $business]);
    }
}
