<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Todos;
use Validator;
use App\Products;
use App\Couriers;
use App\States;
use App\Areas;
use App\Waybills;
use App\DeliveryTimes;
use App\WhatsAppNumber;

class AdminController extends Controller
{
	public function index() {
		$data = [
			'total_orders' => \App\Orders::where('business_id', auth()->id())->count(),
			'total_customers' => \App\Customers::where('business_id', auth()->id())->count(),
			'total_products' => \App\Products::where('business_id', auth()->id())->count(),
			'total_forms' => \App\Forms::where('business_id', auth()->id())->count(),
			'total_delivery_time' => \App\DeliveryTimes::where('business_id', auth()->id())->count(),
		];

		return view('admin.index', $data);
	}

	public function customers() {
		return view('admin.customers', ['customers' => \App\Customers::orderBy('created_at', 'DESC')->where('business_id', auth()->id())->get()]);
	}

	public function formEntriescustomers($id) {
        return view('admin.customers', ['customers' => \App\Customers::orderBy('created_at', 'DESC')->where('business_id', auth()->id())->where('form_id', $id)->get()]);
    }

	public function add_customers() {
		return view('admin.add_customers');
	}

	public function add_customers_post(Request $request) {
		$validator = Validator::make($request->all(), [
    		'firstname' => 'required',
    		'lastname'  => 'required',
    		'phonenumber' => 'required',
    		'phonenumber_two' => 'nullable',
    		'state_id' => 'required',
    		'area_id' => 'required',
    		'address' => 'required'
     	]);

    	if($validator->fails()) {
    		return back()->withErrors($validator);
    	} else {

    		$data = $request->all();

    		$recipient = new Recipients();
     		$recipient->firstname = $data['firstname'];
     		$recipient->lastname  = $data['lastname'];
     		$recipient->phonenumber = $data['phonenumber'];
     		$recipient->phonenumber_two = $data['phonenumber_two'];
     		$recipient->state_id = $data['state_id'];
     		$recipient->area_id = $data['area_id'];
     		$recipient->address = $data['address'];
     		$recipient->save();

    		return back()->with('success', 'Recipient added!');
    	}
	}

	public function edit_recipients($id) {
		$recipient = \App\Recipients::find($id);
		return view('admin.edit_recipients', ['recipient' => $recipient, 'states' => \App\States::all()]);
	}

	public function edit_recipients_post(Request $request, $id) {
		$validator = Validator::make($request->all(), [
    		'firstname' => 'required',
    		'lastname'  => 'required',
    		'phonenumber' => 'required',
    		'phonenumber_two' => 'nullable',
    		'state_id' => 'required',
    		'area_id' => 'required',
    		'address' => 'required'
     	]);

    	if($validator->fails()) {
    		return back()->withErrors($validator);
    	} else {

    		$data = $request->all();

    		$recipient = Recipients::find($id);
     		$recipient->firstname = $data['firstname'];
     		$recipient->lastname  = $data['lastname'];
     		$recipient->phonenumber = $data['phonenumber'];
     		$recipient->phonenumber_two = $data['phonenumber_two'];
     		$recipient->state_id = $data['state_id'];
     		$recipient->area_id = $data['area_id'];
     		$recipient->address = $data['address'];
     		$recipient->save();

    		return back()->with('success', 'Recipient modified!');
    	}
	}

	public function delete_recipients($id) {
		$recipient = \App\Recipients::find($id);
		$recipient->delete();

		Waybills::where('recipient_id', $id)->update(['recipient_id' => 0]);

		return back()->with('success', 'Deleted');
	}

	public function products() {
        if(request()->get('id')) {
            return view('admin.products', ['products' => \App\Products::where('id', request()->get('id'))->where('business_id', auth()->id())->get()]);
        }

		return view('admin.products', ['products' => \App\Products::where('business_id', auth()->id())->get()]);
	}

 public function todos() {
        return view('admin.todos', ['todos' => Todos::all()]);
    }

	public function add_products(Request $request) {
	    $data = [
	        'onboard' => false
        ];
	    if ($request->get('onboard')) {
	        $data['onboard'] = true;
        }
		return view('admin.add_products', $data);
	}

	public function add_products_post(Request $request) {
		$validator = Validator::make($request->all(), [
    		'title' => 'required',
            'qty'   => 'required|numeric',
            'price' => 'required|numeric'
     	]);

    	if($validator->fails()) {
    		return back()->withErrors($validator);
    	} else {

    		$data = $request->all();

			$products = new Products();
			$products->business_id = auth()->id();
     		$products->title = $data['title'];
            $products->qty = $data['qty'];
            $products->price = $data['price'];
     		$products->save();

    		return back()->with('success', 'Product added!');
    	}
	}

	public function edit_products($id) {
		return view('admin.edit_products', ['product' => \App\Products::find($id)]);
	}

	public function edit_products_post(Request $request, $id) {
		$validator = Validator::make($request->all(), [
    		'title' => 'required',
            'qty'   => 'required|numeric',
            'price' => 'required|numeric'
     	]);

    	if($validator->fails()) {
    		return back()->withErrors($validator);
    	} else {

    		$data = $request->all();

    		$products = Products::find($id);
            $products->title = $data['title'];
            $products->qty = $data['qty'];
            $products->price = $data['price'];
            $products->save();

    		return back()->with('success', 'Product modified!');
    	}
	}

	public function delete_products($id) {
		$state = \App\Products::find($id);
		$state->delete();

		return back()->with('success', 'Deleted');
	}

	public function areas() {
		return view('admin.areas', ['areas' => \App\Areas::all()]);
	}

	public function add_areas() {
		return view('admin.add_areas', ['states' => \App\States::all()]);
	}

	public function add_areas_post(Request $request) {
		$validator = Validator::make($request->all(), [
    		'title' => 'required',
    		'state_id' => 'required',
    		'shipping_fee' => 'required'
     	]);

    	if($validator->fails()) {
    		return back()->withErrors($validator);
    	} else {

    		$data = $request->all();

    		$areas = new Areas();
     		$areas->title = $data['title'];
     		$areas->state_id = $data['state_id'];
     		$areas->shipping_fee = $data['shipping_fee'];
     		$areas->save();

    		return back()->with('success', 'Area added!');
    	}
	}

	public function edit_areas($id) {
		return view('admin.edit_areas', ['area' => \App\Areas::find($id), 'states' => \App\States::all()]);
	}

	public function edit_areas_post(Request $request, $id) {
		$validator = Validator::make($request->all(), [
    		'title' => 'required',
    		'state_id' => 'required',
    		'shipping_fee' => 'required'
     	]);

    	if($validator->fails()) {
    		return back()->withErrors($validator);
    	} else {

    		$data = $request->all();

    		$areas = Areas::find($id);
     		$areas->title = $data['title'];
     		$areas->state_id = $data['state_id'];
     		$areas->shipping_fee = $data['shipping_fee'];
     		$areas->save();

    		return back()->with('success', 'Area modified!');
    	}
	}

	public function delete_areas($id) {
		$areas = \App\Areas::find($id);
		$areas->delete();

		return back()->with('success', 'Deleted');
	}

	public function couriers() {
		return view('admin.couriers', ['couriers' => \App\Couriers::all()]);
	}

	public function add_couriers() {
		return view('admin.add_couriers');
	}

	public function add_couriers_post(Request $request) {
		$validator = Validator::make($request->all(), [
    		'name' => 'required',
    		'address' => 'required',
    		'phonenumber' => 'required',
    		'address' => 'required'
     	]);

    	if($validator->fails()) {
    		return back()->withErrors($validator);
    	} else {

    		$data = $request->all();

    		$couriers = new Couriers();
     		$couriers->name = $data['name'];
     		$couriers->address = $data['address'];
     		$couriers->phonenumber = $data['phonenumber'];
     		$couriers->address = $data['address'];

     		$couriers->save();

    		return back()->with('success', 'Courier added!');
    	}
	}

	public function edit_couriers($id) {
		return view('admin.edit_couriers', ['courier' => \App\Couriers::find($id)]);
	}

	public function edit_couriers_post(Request $request, $id) {
		$validator = Validator::make($request->all(), [
    		'name' => 'required',
    		'address' => 'required',
    		'phonenumber' => 'required',
    		'address' => 'required'
     	]);

    	if($validator->fails()) {
    		return back()->withErrors($validator);
    	} else {

    		$data = $request->all();

    		$couriers = Couriers::find($id);
     		$couriers->name = $data['name'];
     		$couriers->address = $data['address'];
     		$couriers->phonenumber = $data['phonenumber'];
     		$couriers->address = $data['address'];

     		$couriers->save();

    		return back()->with('success', 'Courier modified!');
    	}
	}

	public function delete_couriers($id) {
		$courier = \App\Couriers::find($id);
		$courier->delete();

		return back()->with('success', 'Deleted');
	}

	public function deliverytime() {
		return view('admin.deliverytime', ['deliverytime' => \App\DeliveryTimes::where('business_id', auth()->id())->get()]);
	}

	public function add_deliverytime() {
		return view('admin.add_deliverytime');
	}

	public function add_deliverytimePost(Request $request) {
		$validator = Validator::make($request->all(), [
    		'time' => 'required',
     	]);

    	if($validator->fails()) {
    		return back()->withErrors($validator);
    	} else {

    		$data = $request->all();

    		$deliverytime = new DeliveryTimes();
            $deliverytime->business_id = auth()->id();
     		$deliverytime->value = $data['time'];

     		$deliverytime->save();

    		return back()->with('success', 'Delivery Time added!');
    	}
	}

	public function edit_deliverytime($id) {
		return view('admin.edit_deliverytime', ['deliverytime' => \App\DeliveryTimes::find($id)]);
	}

	public function edit_deliverytimePost(Request $request, $id) {
		$validator = Validator::make($request->all(), [
    		'time' => 'required',
     	]);

    	if($validator->fails()) {
    		return back()->withErrors($validator);
    	} else {

    		$data = $request->all();

    		$deliverytime = DeliveryTimes::find($id);
     		$deliverytime->value = $data['time'];
      		$deliverytime->save();

    		return back()->with('success', 'Delivery Time modified!');
    	}
	}

	public function delete_deliverytime($id) {
		$deliverytime = \App\DeliveryTimes::find($id);
		$deliverytime->delete();

		return back()->with('success', 'Deleted');
	}

	public function hide_deliverytime($id) {
			$deliverytime = DeliveryTimes::find($id);
     		$deliverytime->hide = 1;
	 		$deliverytime->save();

    		return back()->with('success', 'Delivery Time hidden!');
	}

	public function unhide_deliverytime($id) {
			$deliverytime = DeliveryTimes::find($id);
     		$deliverytime->hide = 0;
	 		$deliverytime->save();

    		return back()->with('success', 'Delivery Time un-hidden!');
	}

    public function whatsapp_numbers() {
        return view('admin.whatsapp_numbers', ['whatsapp_numbers' => \App\WhatsAppNumber::all()]);
    }

    public function add_whatsapp_numbers() {
        return view('admin.add_whatsapp_numbers');
    }

    public function add_whatsapp_numbers_process(Request $request) {
        $validator = Validator::make($request->all(), [
            'number' => 'required',
            'device_id' => ['required']
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator);
        } else {

            $data = $request->all();

            $whatsapp_numbers = new WhatsAppNumber();
            $whatsapp_numbers->number = $data['number'];
            $whatsapp_numbers->device_id = $data['device_id'];

            $whatsapp_numbers->save();

            return back()->with('success', 'WhatsApp Number added!');
        }
    }

    public function edit_whatsapp_number($id) {
        return view('admin.edit_whatsapp_numbers', ['whatsapp_numbers' => \App\WhatsAppNumber::find($id)]);
    }

    public function edit_whatsapp_number_process(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'number' => 'required',
            'device_id' => ['required']
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator);
        } else {

            $data = $request->all();

            $whatsapp_numbers = \App\WhatsAppNumber::find($id);
            $whatsapp_numbers->number = $data['number'];
            $whatsapp_numbers->device_id = $data['device_id'];

            $whatsapp_numbers->save();

            return back()->with('success', 'WhatsApp Number modified!');
        }
    }

    public function delete_whatsapp_number($id) {
        $whatsapp_numbers = \App\WhatsAppNumber::find($id);
        $whatsapp_numbers->delete();

        return back()->with('success', 'Deleted');
    }

}
