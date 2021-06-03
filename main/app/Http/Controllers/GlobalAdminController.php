<?php

namespace App\Http\Controllers;

use App\User;
use App\Forms;
use App\Store;
use App\Orders;
use App\Wallet;
use App\Business;
use App\Products;
use Carbon\Carbon;
use App\DeliveryTimes;
use App\Subscriptions;
use App\MessageHistory;
use Illuminate\Http\Request;
use App\BusinessSubscription;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class GlobalAdminController extends Controller
{
    /**
     * Index / Reports
     */
    public function index(Request $request) {

        // get users for today
        $todays_users = User::whereDate('created_at', Carbon::today())->count();
        // get total orders
        $total_orders = Orders::all()->count();
        // daily funding
        $daily_funding = Wallet::whereDate('created_at', Carbon::today())->sum('balance');
        // yesterdays users
        $yesterdays_users = User::whereDate('created_at', Carbon::yesterday())->count();
        // delivered orders
        $total_orders = Orders::where('delivery_status', 'Delivered')->count();
        // most used plan
        $subscriptions = BusinessSubscription::where('end_at', '<', time())->get();

        $plans = Subscriptions::all();

        $totalCount = [];
        $most_used_plan = '';

        foreach($plans as $item) {
            // get total count for plan
            $totalCount[$item->id] = BusinessSubscription::where('subscription_id', $item->id)->count();
        }

        $sortMax = max($totalCount);

        $most_used_plan_id = array_keys($totalCount, $sortMax);
        
        $most_used_plan_count = $sortMax;
        $most_used_plan = Subscriptions::where('id', $most_used_plan_id)->first()->title;

        $data = [
            'todays_users'  => $todays_users,
            'total_orders'  => $total_orders,
            'daily_funding' => $daily_funding,
            'yesterdays_users' => $yesterdays_users,
            'total_orders'  => $total_orders,
            'most_used_plan_count'  => $most_used_plan_count,
            'most_used_plan'   => $most_used_plan,
        ];

        return view('gadmin.index', $data);
    }

    /**
     * Businesses
     */
    function businesses(Request $request) {
        $plan = $request->get('plan');
        $plan_id = $request->get('plan_id');

        // First off.. 
        // Get businesses subscribed to a plan
        $subscribers = BusinessSubscription::where('subscription_id', $plan_id)->get();

        // Now Fetch Businesses
        $businesses = [];

        // Loop through subscribers
        foreach($subscribers as $subs) {
            $businesses[] = User::find($subs->user_id);
        }

        return view('gadmin.businesses', ['businesses' => $businesses, 'plan' => Subscriptions::find($plan_id)]);
    }
    /**
     * Products
     */
    public function products() {
        $products = Products::all();
        return view('gadmin.products', ['products' => $products]);
    }
    /**
     * edit product
     */
    public function edit_product($id) {
        $product = Products::find($id);
        return view('gadmin.edit_product', ['product' => $product]);
    } 
    /**
     * edit product post
     */
    public function edit_product_post(Request $request, $id) {
        $request->validate([
            'qty'   => ['required'],
            'title' => ['required'],
            'price' => ['required']
        ]);

        $product = Products::find($id);
        $product->qty = $request->qty;
        $product->title = $request->title;
        $product->price = $request->price;
        $product->save();

        return back()->with('success', 'Product modified.');
    }
    /**
     * delete product
     */
    public function delete_product($id) {
        $product = Products::find($id);
        $product->delete();

        return back()->with('success', 'Product deleted.');
    }

    /**
     * hide product
     */
    public function hide_product($id) {
        $product = Products::find($id);
        $product->is_hidden = true;
        $product->save();

        return back()->with('success', 'Product hidden.');
    }
    /**
     * unhide product
     */
    public function unhide_product($id) {
        $product = Products::find($id);
        $product->is_hidden = false;
        $product->save();

        return back()->with('success', 'Product unhidden.');
    }

    /**
     * disable product
     */
    public function disable_product($id) {
        $product = Products::find($id);
        $product->is_disabled = true;
        $product->save();

        return back()->with('success', 'Product disabled.');
    }
    /**
     * enable product
     */
    public function enable_product($id) {
        $product = Products::find($id);
        $product->is_disabled = false;
        $product->save();

        return back()->with('success', 'Product enabled.');
    }

    /**
    *Forms
    */
    public function forms() {
        $forms = Forms::all();
        return view('gadmin.forms', ['forms' => $forms]);
    }

    /**
     * edit form
     */
    public function edit_form($id) {
        $form = Forms::find($id);
        return view('gadmin.edit_form', ['form' => $form]);
    } 
    /**
     * edit form post
     */
    public function edit_form_post(Request $request, $id) {
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
    /**
     * delete form
     */
    public function delete_form($id) {
        $form = Forms::find($id);
        $form->delete();

        return back()->with('success', 'Form deleted.');
    }

    /**
     * hide form
     */
    public function hide_form($id) {
        $form = Forms::find($id);
        $form->is_hidden = true;
        $form->save();

        return back()->with('success', 'Form hidden.');
    }
    /**
     * unhide form
     */

    public function unhide_form($id) {
        $form = Forms::find($id);
        $form->is_hidden = false;
        $form->save();

        return back()->with('success', 'Form unhidden.');
    }

    /**
     * disable form
     */
    public function disable_form($id) {
        $form = Forms::find($id);
        $form->is_disabled = true;
        $form->save();

        return back()->with('success', 'Form disabled.');
    }
    /**
     * enable form
     */
    public function enable_form($id) {
        $form = Forms::find($id);
        $form->is_disabled = false;
        $form->save();

        return back()->with('success', 'Form enabled.');
    }

    /**
     * Delivery Time
     */
    public function delivery_time() {
        $delivery_times = DeliveryTimes::all();
        return view('gadmin.delivery_times', ['delivery_times' => $delivery_times]);
    } 

    /**
     * edit delivery_time
     */
    public function edit_delivery_time($id) {
        $deliverytime = DeliveryTimes::find($id);
        return view('gadmin.edit_delivery_time', ['deliverytime' => $deliverytime]);
    } 
    /**
     * edit delivery_time post
     */
    public function edit_delivery_time_post(Request $request, $id) {
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

    		return back()->with('success', 'Delivery Time Modified!');
    	}
    }
    /**
     * delete delivery_time
     */
    public function delete_delivery_time($id) {
        $deliverytime = DeliveryTimes::find($id);
        $deliverytime->delete();

        return back()->with('success', 'Delivery Time deleted.');
    }

    /**
     * hide form
     */
    public function hide_delivery_time($id) {
        $deliverytime = DeliveryTimes::find($id);
        $deliverytime->is_hidden = true;
        $fdeliverytimeorm->save();

        return back()->with('success', 'Delivery Time Hidden.');
    }
    /**
     * unhide delivery_time
     */

    public function unhide_delivery_time($id) {
        $deliverytime = DeliveryTimes::find($id);
        $deliverytime->is_hidden = false;
        $deliverytime->save();

        return back()->with('success', 'Delivery Time Unhidden.');
    }

    /**
     * disable delivery_time
     */
    public function disable_delivery_time($id) {
        $deliverytime = DeliveryTimes::find($id);
        $deliverytime->is_disabled = true;
        $deliverytime->save();

        return back()->with('success', 'Delivery Time Disabled.');
    }
    /**
     * enable form
     */
    public function enable_delivery_time($id) {
        $deliverytime = DeliveryTimes::find($id);
        $deliverytime->is_disabled = false;
        $deliverytime->save();

        return back()->with('success', 'Delivery Time enabled.');
    }

    /**
     * Revenue
     */
    public function revenue(Request $request) {
        // Main
        if($request->daterange) {
            $filter = explode(" ", $request->daterange);
            
            $start_date = date('Y-m-d', strtotime($filter[0]));
            $end_date = date('Y-m-d', strtotime($filter[2]));

            $Orders = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date));

            $orders_counted = $Orders->count();
            $total_orders_delivered = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('delivery_status', 'delivered')->get();

            $total_new_orders = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('delivery_status', 'New Order')->get();

            $total_orders = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->get();

            $total_orders_shipped =  Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('delivery_status', 'shipped')->get();
            
            $total_orders_not_shipped =  Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('delivery_status', 'notshipped')->get();
            
            $total_orders_cancelled =  Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('delivery_status', 'cancelled')->get();

            $total_orders_rescheduled = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('delivery_status', 'rescheduled')->get();

            $total_orders_pending = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('delivery_status', 'pending')->get();

            $total_orders_refunded = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('delivery_status', 'refunded')->get();
            
            $total_orders_remitted = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('delivery_status', 'remitted')->get();
            
            $total_orders_ready = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('delivery_status', 'ready')->get();


            $total_orders_failed = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('delivery_status', 'failed')->get();

            $orders_in_transit =  Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('delivery_status', 'shipped')->count();
            
            $orders_notin_transit =  Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('delivery_status', 'notshipped')->count();

            $orders_delivered = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('delivery_status', 'delivered')->count();


            $shipped_value = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))
            ->get();

            // $delivered_percentage = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))
            // ->where('delivery_status', 'delivered')
            // ->count() / @Orders::all()->count() * 100;

            // $shipped_percentage = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))
            // ->where('delivery_status', 'shipped')
            // ->count() / @Orders::all()->count() * 100;

            $failed = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))
            ->where('delivery_status', 'cancelled')
            ->count();
            
            $total_orders_followup = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))
            ->where('delivery_status', 'followup')
            ->get();
            
            $total_orders_deleted =Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))
            ->where('delivery_status', 'deleted')
            ->get();

            // chart

            $delivered_chart_data = [
            
            ];

            $in_transit_chart_data = [];

            $cancelled_chart_data = [];

            $timestamp = strtotime('this week');
            $days = array();

            for ($i = 0; $i < 7; $i++) {
                $days[] = strftime('%A', $timestamp);
                $timestamp = strtotime('-1 day', $timestamp);

                $delivered_chart_data[] = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('delivery_status', 'delivered')->count();

                $in_transit_chart_data[] = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('delivery_status', 'shipped')->count();

                $cancelled_chart_data[] = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('delivery_status', 'cancelled')->count();

                $rescheduled_chart_data[] = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('delivery_status', 'rescheduled')->count();

                $pending_chart_data[] = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('delivery_status', 'pending')->count();

                $refunded_chart_data[] = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('delivery_status', 'refunded')->count();
            }

        } else {

            $currentMonth = date('m');

            $Orders = Orders::whereRaw('MONTH(created_at) = ?',[$currentMonth]);
            $orders_counted = $Orders->count();

            $total_orders_delivered =  DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
            ->where('delivery_status', 'delivered')
            ->get();

            $total_orders =  DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
            ->get();
            
            $total_new_orders = DB::table('orders')->whereRaw('MONTH(created_at) = ?', [$currentMonth])->where('delivery_status', 'New Order')->get();

            $total_orders_shipped = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])->where('delivery_status', 'shipped')
            ->get();
            
            $total_orders_not_shipped = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])->where('delivery_status', 'notshipped')
            ->get();
            
            $total_orders_rescheduled = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])->where('delivery_status', 'rescheduled')
            ->get();

            $total_orders_cancelled = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])->where('delivery_status', 'cancelled')
            ->get();

            $total_orders_pending = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])->where('delivery_status', 'pending')
            ->get();

            $orders_in_transit = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
            ->where('delivery_status', 'shipped')
            ->count();
            
            $orders_notin_transit = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
            ->where('delivery_status', 'notshipped')
            ->count();

            $orders_delivered = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
            ->where('delivery_status', 'delivered')
            ->count();

            $shipped_value = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
            ->count();

            $orders_rescheduled = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
            ->where('delivery_status', 'rescheduled')
            ->count();

            $orders_pending = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
            ->where('delivery_status', 'pending')
            ->count();

            $orders_refunded = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
            ->where('delivery_status', 'refunded')
            ->count();

            $orders_cancelled = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
            ->where('delivery_status', 'cancelled')
            ->count();

            $orders_shipped = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
            ->where('delivery_status', 'shipped')
            ->count();
            
            $orders_notshipped = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
            ->where('delivery_status', 'notshipped')
            ->count();

            $total_orders_refunded = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])->where('delivery_status', 'refunded')
            ->get();
            
            $total_orders_remitted = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])->where('delivery_status', 'remitted')
            ->get();
            
            $total_orders_ready = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])->where('delivery_status', 'ready')
            ->get();
            
            $total_orders_failed = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])->where('delivery_status', 'failed')
            ->get();
            
            $total_orders_followup = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])->where('delivery_status', 'followup')
            ->get();

            $total_orders_deleted = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])->where('delivery_status', 'deleted')
            ->get();


            // $delivered_percentage = DB::table("orders")
            // ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
            // ->where('delivery_status', 'delivered')
            // ->count() / Orders::all()->count() * 100;

            // $shipped_percentage = DB::table("orders")
            // ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
            // ->where('delivery_status', 'shipped')
            // ->count() / Orders::all()->count() * 100;

            $failed = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
            ->where('delivery_status', 'cancelled')
            ->count();

    
            $delivered_chart_data = [
            
            ];

            $in_transit_chart_data = [];

            $cancelled_chart_data = [];

            $timestamp = strtotime('this week');
            $days = array();

            for ($i = 0; $i < 31; $i++) {
                
                $days[] = strftime('%A', $timestamp);
                $timestamp = strtotime('-1 day', $timestamp);

                $currentMonth = date('m');

                $delivered_chart_data[] = Orders::whereRaw('MONTH(created_at) = ?',[$currentMonth])->where('delivery_status', 'delivered')->count();

                $in_transit_chart_data[] = Orders::whereRaw('MONTH(created_at) = ?',[$currentMonth])->where('delivery_status', 'shipped')->count();

                $cancelled_chart_data[] = Orders::whereRaw('MONTH(created_at) = ?',[$currentMonth])->where('delivery_status', 'cancelled')->count();

                $rescheduled_chart_data[] = Orders::whereRaw('MONTH(created_at) = ?',[$currentMonth])->where('delivery_status', 'rescheduled')->count();

                $pending_chart_data[] = Orders::whereRaw('MONTH(created_at) = ?',[$currentMonth])->where('delivery_status', 'pending')->count();

                $refunded_chart_data[] = Orders::whereRaw('MONTH(created_at) = ?',[$currentMonth])->where('delivery_status', 'refunded')->count();
            
            }

        }

        if($Orders->count() > 0) {

            // delivered value
            $delivery_value = 0;
            $delivery_value_array = [];
            foreach($total_orders_delivered as $t) {
                $delivery_value_array[] = $t->product_total_price;
            }

            $delivery_v = array_sum($delivery_value_array);

            // shipped value
            $shipped_value = 0;
            $shipped_value_array = [];
            foreach($total_orders_shipped as $t) {
                $shipped_value_array[] = $t->product_total_price;
            }

            $shipped_value = array_sum($shipped_value_array);
            
            // not shipped value
            $notshipped_value = 0;
            $notshipped_value_array = [];
            foreach($total_orders_not_shipped as $t) {
                $notshipped_value_array[] = $t->product_total_price;
            }

            $notshipped_value = array_sum($notshipped_value_array);

            // rescheduled value
            $rescheduled_value = 0;
            $rescheduled_value_array = [];
            foreach($total_orders_rescheduled as $t) {
                $rescheduled_value_array[] = $t->product_total_price;
            }

            $rescheduled_value = array_sum($rescheduled_value_array);

            // pending
            $pending_value = 0;
            $pending_value_array = [];
            foreach($total_orders_pending as $t) {
                $pending_value_array[] = $t->product_total_price;
            }

            $pending_value = array_sum($pending_value_array);

            // cancelled value
            $cancelled_value = 0;
            $cancelled_value_array = [];
            foreach($total_orders_cancelled as $t) {
                $cancelled_value_array[] = $t->product_total_price;
            }

            $cancelled_value = array_sum($cancelled_value_array);

            // refunded value
            $refunded_value = 0;
            $refunded_value_array = [];
            foreach($total_orders_refunded as $t) {
                $refunded_value_array[] = $t->product_total_price;
            }
            
            $refunded_value = array_sum($refunded_value_array);
            
            // remitted value
            $remitted_value = 0;
            $remitted_value_array = [];
            foreach($total_orders_remitted as $t) {
                $remitted_value_array[] = $t->product_total_price;
            }
            
            $remitted_value = array_sum($remitted_value_array);
            
            // ready value
            $ready_value = 0;
            $ready_value_array = [];
            foreach($total_orders_ready as $t) {
                $ready_value_array[] = $t->product_total_price;
            }

            $ready_value = array_sum($ready_value_array);
            
            // failed value
            $failed_value = 0;
            $failed_value_array = [];
            foreach($total_orders_failed as $t) {
                $failed_value_array[] = $t->product_total_price;
            }

            $failed_value = array_sum($failed_value_array);
            
            // followup value
            $followup_value = 0;
            $followup_value_array = [];
            foreach($total_orders_followup as $t) {
                $followup_value_array[] = $t->product_total_price;
            }

            $followup_value = array_sum($followup_value_array);
            
            // deleted value
            $deleted_value = 0;
            $deleted_value_array = [];
            foreach($total_orders_deleted as $t) {
                $deleted_value_array[] = $t->product_total_price;
            }

            $deleted_value = array_sum($deleted_value_array);

             // all value
            $all_values = 0;
            $all_value_array = [];
            $all_value = [];
            
            foreach($total_orders as $t) {
                $all_value[] = $t->product_total_price;
            }

            $all_values = array_sum($all_value);

            $new_values = 0;
            $new_value_array = [];
            
            foreach($total_new_orders as $t) {
                $new_value_array[] = $t->product_total_price;
            }

            $new_values = array_sum($new_value_array);
            
            $currentMonth = date('m');
            
            $data = [
                'orders_ingested'   =>  $orders_counted,
                'orders_in_transit' => $orders_in_transit,
                'orders_not_in_transit' => $orders_notin_transit,
                'orders_delivered'  =>  $orders_delivered,
                'orders_rescheduled' => count($total_orders_rescheduled),
                'orders_pending' => count($total_orders_pending),
                'orders_cancelled' => count($total_orders_cancelled),
                'orders_refunded' => count($total_orders_refunded),
                'orders_remitted_stat' => count($remitted_value_array),
                'orders_ready_stat' => count($ready_value_array),
                'orders_failed_stat' => count($failed_value_array),
                'orders_followup_stat' => count($followup_value_array),
                'orders_deleted_stat' => count($deleted_value_array),
      
                
                'orders_remitted' => $remitted_value,
                'orders_ready' => $ready_value,

                'delivered_chart' => $delivered_chart_data,
                'in_transit_chart' => $in_transit_chart_data,
                'cancelled_chart' => $cancelled_chart_data,
                'refunded_chart' => $refunded_chart_data,
                'pending_chart' => $pending_chart_data,
                'rescheduled_chart' => $rescheduled_chart_data,

                'rescheduled_value' => $rescheduled_value,
                'pending_value' => $pending_value,
                'refunded_value' => $refunded_value,
                'orders_failed' => $failed_value,
                'followup' => $followup_value,
                'deleted' => $deleted_value,

                'delivered_value' => $delivery_v,
                'shipped_value' => $shipped_value,
                'notshipped_value' => $notshipped_value,
                'cancelled_value' => $cancelled_value,
                'all_value'  => $all_values,
                'orders_new'  => $total_new_orders->count(),
                'new_value' => $new_values,
                'failed'    => $Orders->where('delivery_status', 'cancelled')->count(),
                'delivered_percentage' => 0,
                'shipped_percentage' => 0
            ];

        } else {

            $data = [
                'orders_new' => 0,
                'new_value' => 0,
                'orders_ingested'   =>  0,
                'orders_in_transit' => 0,
                'orders_not_in_transit' => 0,
                'orders_delivered'  =>  0,
                'orders_rescheduled' => 0,
                'orders_pending' => 0,
                'orders_cancelled' => 0,
                'orders_refunded' => 0,
                'orders_remitted_stat' => 0,
                'orders_ready_stat' => 0,
                'orders_remitted' => 0,
                'orders_ready' => 0,
                'orders_failed' => 0,
                'orders_followup_stat' => 0,
                'orders_deleted_stat' => 0,
                'followup' => 0,
                'deleted' => 0,

                'delivered_chart' => [0,0,0,0,0,0,0],
                'in_transit_chart' => [0,0,0,0,0,0,0],
                'cancelled_chart' => [0,0,0,0,0,0,0],
                'refunded_chart' => [0,0,0,0,0,0,0],
                'pending_chart' => [0,0,0,0,0,0,0],
                'rescheduled_chart' => [0,0,0,0,0,0,0],

                'rescheduled_value' => 0,
                'pending_value' => 0,
                'refunded_value' => 0,
                'orders_failed_stat' => 0,

                'delivered_value' => 0,
                'shipped_value' => 0,
                'notshipped_value' => 0,
                'cancelled_value' => 0,
                'all_value'  => 0,
                'failed'        => 0,
                'delivered_percentage' => 0,
                'shipped_percentage' => 0
            ];
        }

        return view('gadmin.revenue', $data);
    }
    /**
     * Message Logs
     */
    public function message_logs() {
        $messages = MessageHistory::all();
        return view('gadmin.message_history', ['messages' => $messages]);
    }
    /**
     * Clear Logs
     */
    public function clear_message_logs() {
        MessageHistory::truncate();

        return back()->with('success', 'Message logs cleared.');
    }

    /**
     * Business Update Details
     */
    public function businesses_update_details($id) {
        $business = Business::where('user_id', $id)->firstOrFail();

        return view('gadmin.update_business_details', ['business' => $business]);
    }

    /**
     * Update Business Details POST
     */
    public function businesses_update_details_post(Request $request, $id) {
        $request->validate([
            'business_name'         => ['required'],
            'business_address'      => ['required'],
            'business_phone_number' => ['required'],
            'business_email'        => ['required'],
        ]);

        $business = Business::where('user_id', $id)->firstOrFail();
        $business->business_name    = $request->business_name;
        $business->business_address = $request->business_address;
        $business->business_phone_number = $request->business_phone_number;
        $business->business_email = $request->business_email;
        $business->save();

        return back()->with('success', 'Business Details Updated');
    }

    /**
     * Update Profile
     */
    public function businesses_update_profile_details($id) {
        $profile = User::find($id);

        return view('gadmin.update_user_details', ['profile' => $profile]);
    }
    /**
     * Update Profile Post
     */
    public function businesses_update_profile_details_post(Request $request, $id) {
        $request->validate([
            'firstname' => ['required'],
            'lastname'  => ['required'],
            'address'   => ['required'],
            'phone_number' => ['required'],
        ]);

        $profile = User::find($id);
        $profile->firstname = $request->firstname;
        $profile->lastname  = $request->lastname;
        $profile->address   = $request->address;
        $profile->phone_number = $request->phone_number;
        $profile->save();

        return back()->with('success', 'Profile updated');
    }
    /**
     * Delete Business
     */
    public function businesses_delete($id) {
        $user = User::find($id);
        $user->delete();

        $b = Business::where('user_id', $id)->first();
        $b->delete();

        $bb = BusinessSubscription::where('user_id', $id)->first();
        $bb->delete();

        return back()->with('success', 'Business deleted');
    }
    /**
     * Ban Business
     */
    public function businesses_ban($id) {
        $user = User::find($id);
        $user->is_banned = true;
        $user->save();

        return back()->with('success', 'Business Banned.');
    }
    /**
     * Unban Business
     */
    public function businesses_unban($id) {
        $user = User::find($id);
        $user->is_banned = false;
        $user->save();

        return back()->with('success', 'Business UnBanned.');
    }
    /**
     * Stores
     */
    public function stores() {
        $stores = Store::all();
        return view('gadmin.stores', ['stores' => $stores]);
    }

    /**
     * edit store
     */
    public function edit_store($id) {
        $store = Store::find($id);
        return view('gadmin.edit_store', ['store' => $store]);
    } 
    /**
     * edit store post
     */
    public function edit_store_post(Request $request, $id) {
        $request->validate([
            // 'store_url_lug'        => ['required', 'unique:stores'],
            'store_title'           => ['required'],
            'store_header_color'    => ['required'],
            'store_font_color'      => ['required'],
            'store_footer_color'    => ['required']
        ]);

        $store = Store::find($id);
        $store->store_url_slug = $request->store_url_slug;
        $store->store_title = $request->store_title;
        $store->store_header_color = $request->store_header_color;
        $store->store_font_color = $request->store_font_color;
        $store->store_footer_color = $request->store_footer_color;
        $store->save();

        return redirect('/gadmin/stores')->with('success', 'Store updated.');
    }
    /**
     * delete store
     */
    public function delete_store($id) {
        $store = Store::find($id);
        $store->delete();

        return back()->with('success', 'Store deleted.');
    }

    /**
     * hide store
     */
    public function hide_store($id) {
        $store = Store::find($id);
        $store->is_hidden = true;
        $store->save();

        return back()->with('success', 'Store hidden.');
    }
    /**
     * unhide store
     */

    public function unhide_store($id) {
        $store = Store::find($id);
        $store->is_hidden = false;
        $store->save();

        return back()->with('success', 'Store unhidden.');
    }

    /**
     * disable store
     */
    public function disable_store($id) {
        $store = Store::find($id);
        $store->is_disabled = true;
        $store->save();

        return back()->with('success', 'Form disabled.');
    }
    /**
     * enable form
     */
    public function enable_store($id) {
        $store = Store::find($id);
        $store->is_disabled = false;
        $store->save();

        return back()->with('success', 'Store enabled.');
    }
    /**
     * Referrals
     */
    public function referrals() {
        $referrals = Referral::all();

        return view('gadmin.referrals', ['referrals' => $referrals]);
    }
}
