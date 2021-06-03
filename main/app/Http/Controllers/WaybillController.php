<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Couriers;
use App\Recipients;
use App\States;
use Validator;
use App\Waybills;
use App\WaybillTracking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WaybillController extends Controller
{
    public function generateView() {
    	$dropoffpoint = Couriers::find(1);
    	$dropoffpointall = Couriers::all();
    	$recipients = Recipients::all();
    	$states = States::all();

    	$data['dropoffpoint'] = $dropoffpoint;
    	$data['dropoffpointall'] = $dropoffpointall;
    	$data['recipients'] = $recipients;
    	$data['states'] = $states;

    	return view('waybill.generate', $data);
    }

    public function generatePost(Request $request) {

    	$validator = Validator::make($request->all()['data'], [
    		'dropoffpoint' => 'required',
    		'sender'  => 'required',
    		'recipient' => 'required',
    		'shipping_fee' => 'required',
    		'date_of_shipment' => 'required',
    		'payment_method' => 'required',
    		'shipment_type' => 'required',
    		'reference_number' => 'nullable',

    		'packages_item_name' => 'required',
    		'packages_item_unit_price' => 'required',
    		'packages_item_qty'   => 'required',
    		'packages_item_total_price' => 'required',
    		'packages_weight' => 'required'
     	]);

     	$data = $request->input('data');

     	$validator->after(function ($validator) use ($data) {
	        if ($data['packages_item_name'][0] == NULL) {
	            $validator->errors()->add('packages_item_name', 'Please provide at-least 1 package item name!');
	        }

	        if ($data['packages_item_unit_price'][0] == NULL) {
	            $validator->errors()->add('packages_item_name', 'Please provide at-least 1 package item unit price!');
	        }

	        if ($data['packages_item_qty'][0] == NULL) {
	            $validator->errors()->add('packages_item_name', 'Please provide at-least 1 package item quantity!');
	        }
	    });

     	// var_dump($request->input('data'));
     	// die;

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

     		$waybill_code = strtoupper("PM".str_random(9));

     		$waybill = Waybills::firstOrCreate([
     			'creator_id'    			=> Auth::id(),
     			'courier_id'   				=> $data['dropoffpoint'],
     			'waybill_code' 				=> $waybill_code,
     			'sender'       				=> $data['sender'],
     			'recipient_id' 				=> $data['recipient'],
     			'shipping_fee' 				=> $data['shipping_fee'],
     			'shipment_type'             => $data['shipment_type'],
     			'date_of_shipment'  		=> $data['date_of_shipment'],
     			'payment_method'			=> $data['payment_method'],
     			'reference_number'  		=> $data['reference_number'],
     			'packages_count'    		=> count($data['packages_item_name']),
     			'packages_item_name'      	=> json_encode($data['packages_item_name']),
     			'packages_item_qty' 		=> json_encode($data['packages_item_qty']),
     			'packages_item_unit_price'  => json_encode($data['packages_item_unit_price']),
     			'packages_item_total_price' => json_encode($data['packages_item_total_price']),
     			'packages_weight' 			=> $data['packages_weight'],
     			'delivery_status'			=> 'Waybill Created', 
     		]);


     		$waybill_tracking = new WaybillTracking();
     		$waybill_tracking->waybill_code = $waybill_code;
     		$waybill_tracking->waybill_id = $waybill->id;
     		$waybill_tracking->status = 'Waybill Created';
     		$waybill_tracking->desc = 'Waybill has been generated';
     		$waybill_tracking->save();

     		$message = "
     			<a href='/waybills/view/".$waybill_code."' class='btn btn-block btn-success'>View waybill <i class='fa fa-link'></i> </a>
     		";

     		return \response()->json(['code' => 200, 'message' => $message]);

     	}
    }

    public function editWaybills($code) {
        $waybill = Waybills::where('waybill_code', $code)->first();

        $dropoffpoint = Couriers::find($waybill->courier_id);
        $dropoffpointall = Couriers::all();
        $recipients = Recipients::all();
        $states = States::all();

        $data['dropoffpoint'] = $dropoffpoint;
        $data['dropoffpointall'] = $dropoffpointall;
        $data['recipients'] = $recipients;
        $data['states'] = $states;
        $data['waybill'] = $waybill;

        return view('waybill.edit', $data);
    }

    public function editWaybillsPost(Request $request, $code) {

        $validator = Validator::make($request->all()['data'], [
            'dropoffpoint' => 'required',
            'sender'  => 'required',
            'recipient' => 'required',
            'shipping_fee' => 'required',
            'date_of_shipment' => 'required',
            'payment_method' => 'required',
            'shipment_type' => 'required',
            'reference_number' => 'nullable',

            'packages_item_name' => 'required',
            'packages_item_unit_price' => 'required',
            'packages_item_qty'   => 'required',
            'packages_item_total_price' => 'required',
            'packages_weight' => 'required'
        ]);

        $data = $request->input('data');

        $validator->after(function ($validator) use ($data) {
            if ($data['packages_item_name'][0] == NULL) {
                $validator->errors()->add('packages_item_name', 'Please provide at-least 1 package item name!');
            }

            if ($data['packages_item_unit_price'][0] == NULL) {
                $validator->errors()->add('packages_item_name', 'Please provide at-least 1 package item unit price!');
            }

            if ($data['packages_item_qty'][0] == NULL) {
                $validator->errors()->add('packages_item_name', 'Please provide at-least 1 package item quantity!');
            }
        });

        // var_dump($request->input('data'));
        // die;

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

            $waybill = Waybills::where('waybill_code', $code)->first();

            $waybill->update([
                'creator_id'                => $waybill->creator_id,
                'courier_id'                => $data['dropoffpoint'],
                'sender'                    => $data['sender'],
                'recipient_id'              => $data['recipient'],
                'shipping_fee'              => $data['shipping_fee'],
                'shipment_type'             => $data['shipment_type'],
                'date_of_shipment'          => $data['date_of_shipment'],
                'payment_method'            => $data['payment_method'],
                'reference_number'          => $data['reference_number'],
                'packages_count'            => count($data['packages_item_name']),
                'packages_item_name'        => json_encode($data['packages_item_name']),
                'packages_item_qty'         => json_encode($data['packages_item_qty']),
                'packages_item_unit_price'  => json_encode($data['packages_item_unit_price']),
                'packages_item_total_price' => json_encode($data['packages_item_total_price']),
                'packages_weight'           => $data['packages_weight'],
            ]);

            $message = "
                <a href='/waybills/view/".$code."' class='btn btn-block btn-success'>View waybill <i class='fa fa-link'></i> </a>
            ";

            return \response()->json(['code' => 200, 'message' => $message]);
        }
    }

    public function viewWaybills(Request $request) {
    	// Default data source
    	$waybills = Waybills::orderBy('created_at', 'DESC')->get();

    	// Filter
    	if($request->daterange) {
    		$filter = explode(" ", $request->daterange);
    		
    		$start_date = date('Y-m-d', strtotime($filter[0]));
    		$end_date = date('Y-m-d', strtotime($filter[2]));

    		$waybills = Waybills::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->orderBy('created_at', 'DESC')->get();
    	}

        if($request->status != '' AND $request->daterange != '') {
            $filter = explode(" ", $request->daterange);
            $status = $request->status;
            
            $start_date = date('Y-m-d', strtotime($filter[0]));
            $end_date = date('Y-m-d', strtotime($filter[2]));

            $waybills = Waybills::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('delivery_status', $status)->orderBy('created_at', 'DESC')->get();
        }

        if($request->status) {
            $status = $request->status;
            $waybills = Waybills::where('delivery_status', $status)->orderBy('created_at', 'DESC')->get();
        }

    	// Search
    	if($request->text) {
            $search_type = $request->search_type;

            if($search_type == 'number') {

        		$waybill_number = $request->text;

        		$waybills = Waybills::where('waybill_code', $waybill_number)->orderBy('created_at', 'DESC')->get();

            } elseif ($search_type == 'area') {

                $area = $request->text;

                // find waybills with such recipient address...

                // first get all recipients with such address
                $recipients = Recipients::where('address', 'LIKE', '%'.$area.'%')->get();

                // loop em then add to get waybill and add to waybill array
                $waybills = [];

                // loop recipients
                foreach($recipients as $recipient) {
                    // check if user has waybill
                    $waybills_check = Waybills::where('recipient_id', $recipient->id)->count();

                    if($waybills_check > 0) {
                        // now get the fucking waybills
                        // $waybillss = Waybills::where('recipient_id', $recipient->id)->get();
                        $waybills[] = DB::table('waybills')->where('recipient_id', $recipient->id)->get();
                        // $waybills[] = $waybillss;
                    }
                }

                // dd($waybills);
                //die;
            }
    	}

    	$data = [
    		'waybills' => $waybills
    	];

    	return view('waybill.view_all', $data);
    }

    public function viewWaybill($code) {
    	$waybill = Waybills::where('waybill_code', $code)->firstOrFail();

    	$data = [
    		'waybill' => $waybill
    	];

    	return view('waybill.view_waybill', $data);
    }

    public function deleteWaybills($code) {
        $areas = \App\Waybills::where('waybill_code', $code)->first();
        $areas->delete();

        return redirect('/waybills/view/all')->with('success', 'Deleted');
    }
}
