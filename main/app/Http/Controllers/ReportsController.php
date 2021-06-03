<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Orders;
use DB;
use Carbon\Carbon;
use App\Customers;
use App\Forms;
use App\Models\Referral;

class ReportsController extends Controller
{
    public function index(Request $request) {

    	// Main
    	if($request->daterange) {

            $filter = $request->daterange;

            $start_date = '';
            $end_date = '';

            switch($filter) {
                case "today":
                    $start_date = date('Y-m-d');
                    $end_date = date('Y-m-d');
                break;

                case "week":
                    $start_date = date("Y-m-d", strtotime('monday this week'));
                    $end_date = date("Y-m-d", strtotime('sunday this week'));
                break;

                case "month":
                    $start_date = date("Y-m-d", strtotime('first day of this month'));
                    $end_date = date("Y-m-d", strtotime('last day of this month'));
                break;

                case "year":
                    $start_date = date("Y-m-d", strtotime('first day of this year'));
                    $end_date = date("Y-m-d", strtotime('last day of this year'));
                break;

                case "yesterday":
                    $start_date = date("Y-m-d", strtotime("yesterday"));
                    $end_date = date("Y-m-d", strtotime("yesterday"));
                break;
            }

    		$Orders = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date));

    		$orders_counted = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('business_id', auth()->id())->count();

    		$total_orders_delivered = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('delivery_status', 'delivered')->where('business_id', auth()->id())->get();

            $total_new_orders = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('delivery_status', 'New Order')->where('business_id', auth()->id())->get();

            $total_orders = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('business_id', auth()->id())->count();

            $month_orders_array = DB::table('orders')->whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('business_id', auth()->id())->get();

    		$total_orders_shipped =  Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('delivery_status', 'shipped')->where('business_id', auth()->id())->get();

    		$total_orders_not_shipped =  Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('delivery_status', 'notshipped')->where('business_id', auth()->id())->get();

    		$total_orders_cancelled =  Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('delivery_status', 'cancelled')->where('business_id', auth()->id())->get();

    		$total_orders_rescheduled = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('delivery_status', 'rescheduled')->where('business_id', auth()->id())->get();

    		$total_orders_pending = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('delivery_status', 'pending')->where('business_id', auth()->id())->get();

    		$total_orders_refunded = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('delivery_status', 'refunded')->where('business_id', auth()->id())->get();

    		$total_orders_remitted = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('delivery_status', 'Payment Received')->where('business_id', auth()->id())->get();

    		$total_orders_ready = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('delivery_status', 'Ready For Delivery')->where('business_id', auth()->id())->get();


			$total_orders_failed = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('delivery_status', 'failed')->where('business_id', auth()->id())->get();

    		$orders_in_transit =  Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('delivery_status', 'shipped')->where('business_id', auth()->id())->count();

    		$orders_notin_transit =  Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('delivery_status', 'notshipped')->where('business_id', auth()->id())->count();

            $orders_delivered = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('delivery_status', 'delivered')->where('business_id', auth()->id())->count();


            $shipped_value = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))
            ->where('business_id', auth()->id())->get();

            // $delivered_percentage = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))
            // ->where('delivery_status', 'delivered')
            // ->count() / @Orders::all()->count() * 100;

            // $shipped_percentage = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))
            // ->where('delivery_status', 'shipped')
            // ->count() / @Orders::all()->count() * 100;

            $failed = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))
            ->where('delivery_status', 'cancelled')
			->where('business_id', auth()->id())->count();

			$total_orders_followup = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))
            ->where('delivery_status', 'followup')
			->where('business_id', auth()->id())->get();

			$total_orders_deleted =Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))
            ->where('delivery_status', 'deleted')
			->where('business_id', auth()->id())->get();

            // chart

			$delivered_chart_data = [

			];

			$in_transit_chart_data = [];

			$cancelled_chart_data = [];

			$timestamp = strtotime('this year');
            $days = array();

            $orders_chart = [];

			for ($i = 0; $i < 12; $i++) {
			    $days[] = strftime('%A', $timestamp);
                $timestamp = strtotime('-1 month', $timestamp);

                $orders_chart[] = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('business_id', auth()->id())->count();

			    $delivered_chart_data[] = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('delivery_status', 'delivered')->where('business_id', auth()->id())->count();

			    $in_transit_chart_data[] = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('delivery_status', 'shipped')->where('business_id', auth()->id())->count();

			    $cancelled_chart_data[] = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('delivery_status', 'cancelled')->where('business_id', auth()->id())->count();

			    $rescheduled_chart_data[] = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('delivery_status', 'rescheduled')->where('business_id', auth()->id())->count();

			    $pending_chart_data[] = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('delivery_status', 'pending')->where('business_id', auth()->id())->count();

			    $refunded_chart_data[] = Orders::whereBetween(DB::raw('DATE(created_at)'), array($start_date, $end_date))->where('delivery_status', 'refunded')->where('business_id', auth()->id())->count();
			}

    	} else {

    		$currentMonth = date('m');

    		$Orders = Orders::whereRaw('MONTH(created_at) = ?',[$currentMonth]);

            $orders_counted = Orders::whereRaw('MONTH(created_at) = ?', [$currentMonth])->where('business_id', auth()->id())->count();

            $month_orders_array = DB::table('orders')->whereRaw('MONTH(created_at) = ?', [$currentMonth])->where('business_id', auth()->id())->get();

    		$total_orders_delivered =  DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
            ->where('delivery_status', 'delivered')
            ->where('business_id', auth()->id())->get();

            $total_orders =  DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
            ->where('business_id', auth()->id())->count();

            $total_new_orders = DB::table('orders')->whereRaw('MONTH(created_at) = ?', [$currentMonth])->where('delivery_status', 'New Order')->where('business_id', auth()->id())->get();

            $total_orders_shipped = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])->where('delivery_status', 'shipped')
            ->where('business_id', auth()->id())->get();

            $total_orders_not_shipped = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])->where('delivery_status', 'notshipped')
            ->where('business_id', auth()->id())->get();

            $total_orders_rescheduled = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])->where('delivery_status', 'rescheduled')
            ->where('business_id', auth()->id())->get();

            $total_orders_cancelled = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])->where('delivery_status', 'cancelled')
            ->where('business_id', auth()->id())->get();

            $total_orders_pending = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])->where('delivery_status', 'pending')
            ->where('business_id', auth()->id())->get();

            $orders_in_transit = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
            ->where('delivery_status', 'shipped')
            ->where('business_id', auth()->id())->count();

            $orders_notin_transit = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
            ->where('delivery_status', 'notshipped')
            ->where('business_id', auth()->id())->count();

            $orders_delivered = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
            ->where('delivery_status', 'delivered')
            ->where('business_id', auth()->id())->count();

            $shipped_value = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
            ->where('business_id', auth()->id())->count();

            $orders_rescheduled = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
            ->where('delivery_status', 'rescheduled')
            ->where('business_id', auth()->id())->count();

            $orders_pending = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
            ->where('delivery_status', 'pending')
            ->where('business_id', auth()->id())->count();

            $orders_refunded = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
            ->where('delivery_status', 'refunded')
            ->where('business_id', auth()->id())->count();

            $orders_cancelled = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
            ->where('delivery_status', 'cancelled')
            ->where('business_id', auth()->id())->count();

            $orders_shipped = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
            ->where('delivery_status', 'shipped')
            ->where('business_id', auth()->id())->count();

            $orders_notshipped = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
            ->where('delivery_status', 'notshipped')
            ->where('business_id', auth()->id())->count();

            $total_orders_refunded = DB::table("orders")
            ->where('delivery_status', 'refunded')
            ->where('business_id', auth()->id())->get();

            $total_orders_remitted = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])->where('delivery_status', 'Payment Received')
            ->where('business_id', auth()->id())->get();

            $total_orders_ready = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])->where('delivery_status', 'Ready for Delivery')
            ->where('business_id', auth()->id())->get();

            $total_orders_failed = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])->where('delivery_status', 'failed')
			->where('business_id', auth()->id())->get();

			$total_orders_followup = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])->where('delivery_status', 'followup')
            ->where('business_id', auth()->id())->get();

			$total_orders_deleted = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])->where('delivery_status', 'deleted')
            ->where('business_id', auth()->id())->get();


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
            ->where('business_id', auth()->id())->count();


            $delivered_chart_data = [

			];

			$in_transit_chart_data = [];

			$cancelled_chart_data = [];

			$timestamp = strtotime('this year');
			$days = array();

			for ($i = 0; $i < 12; $i++) {
			    $days[] = strftime('%A', $timestamp);
			    $timestamp = strtotime('-1 month', $timestamp);

			    $currentMonth = date('m');

                $orders_chart[] = Orders::whereRaw('MONTH(created_at) = ?',[$currentMonth])->where('business_id', auth()->id())->count();

			    $delivered_chart_data[] = Orders::whereRaw('MONTH(created_at) = ?',[$currentMonth])->where('delivery_status', 'delivered')->where('business_id', auth()->id())->count();

			    $in_transit_chart_data[] = Orders::whereRaw('MONTH(created_at) = ?',[$currentMonth])->where('delivery_status', 'shipped')->where('business_id', auth()->id())->count();

			    $cancelled_chart_data[] = Orders::whereRaw('MONTH(created_at) = ?',[$currentMonth])->where('delivery_status', 'cancelled')->where('business_id', auth()->id())->count();

			    $rescheduled_chart_data[] = Orders::whereRaw('MONTH(created_at) = ?',[$currentMonth])->where('delivery_status', 'rescheduled')->where('business_id', auth()->id())->count();

			    $pending_chart_data[] = Orders::whereRaw('MONTH(created_at) = ?',[$currentMonth])->where('delivery_status', 'pending')->where('business_id', auth()->id())->count();

				$refunded_chart_data[] = Orders::whereRaw('MONTH(created_at) = ?',[$currentMonth])->where('delivery_status', 'refunded')->where('business_id', auth()->id())->count();

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

            $orders_new = count($total_new_orders);

		    $today_sales_array = DB::table('orders')->whereDate('created_at', Carbon::today())->where('delivery_status', 'New Order')->where('business_id', auth()->id())->get();
		    $today_sales_values = [];

		    foreach($today_sales_array as $t) {
		        $today_sales_values[] = $t->product_total_price;
		    }

		    $today_sales = array_sum($today_sales_values);

		    $today_orders_array = DB::table('orders')->whereDate('created_at', Carbon::today())->where('business_id', auth()->id())->get();

		    $today_orders = count($today_orders_array);


		    $month_orders_values = [];

		    foreach($month_orders_array as $t) {
		        $month_orders_values[] = $t->product_total_price;
		    }

		    $month_sales = array_sum($month_orders_values);
		    $month_orders = count($month_orders_array);

            $num_referred_users = Referral::where('referrer_id', auth()->id())->count();

	    	$data = [
                'total_new_orders'   =>  $total_new_orders,
                'total_orders'   =>  $total_orders,
                'total_orders_remitted' => array_sum($remitted_value_array),
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
				'today_sales'        => $today_sales,
				'today_orders'       => $today_orders,
				'month_orders' => $month_orders,
                'month_sales' => $month_sales,

                'num_referred_users' => $num_referred_users,

                'orders_chart' => $orders_chart,

	    		'orders_remitted' => $remitted_value,
	    		'orders_ready' => $ready_value,

	    		'delivered_chart' => $delivered_chart_data,
	    		'in_transit_chart' => $in_transit_chart_data,
	    		'cancelled_chart' => $cancelled_chart_data,
	    		'refunded_chart' => $refunded_chart_data,
	    		'pending_chart' => $pending_chart_data,
	    		'rescheduled_chart' => $rescheduled_chart_data,

	    		'rescheduled_value' => $rescheduled_value,
	    		'pending_value'	=> $pending_value,
	    		'refunded_value' => $refunded_value,
				'orders_failed' => $failed_value,
				'followup' => $followup_value,
				'deleted' => $deleted_value,

	    		'delivered_value' => $delivery_v,
	    		'shipped_value' => $shipped_value,
	    		'notshipped_value' => $notshipped_value,
	    		'cancelled_value' => $cancelled_value,
	    		'all_value'  => $all_values,
	    		'orders_new'  => $month_orders,
	    		'new_value' => $new_values,
	    		'failed'  	=> Orders::whereDate('created_at', $dateFilter)->where('delivery_status', 'cancelled')->count(),
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
				'today_sales'        => 0,
				'today_orders'       => 0,
				'month_orders' => 0,
				'month_sales' => 0,
                'orders_chart' => [0,0,0,0,0,0,0,0,0,0,0,0],
	    		'delivered_chart' => [0,0,0,0,0,0,0],
	    		'in_transit_chart' => [0,0,0,0,0,0,0],
	    		'cancelled_chart' => [0,0,0,0,0,0,0],
	    		'refunded_chart' => [0,0,0,0,0,0,0],
	    		'pending_chart' => [0,0,0,0,0,0,0],
	    		'rescheduled_chart' => [0,0,0,0,0,0,0],

	    		'rescheduled_value' => 0,
	    		'pending_value'	=> 0,
	    		'refunded_value' => 0,
	    		'orders_failed_stat' => 0,

	    		'delivered_value' => 0,
	    		'shipped_value' => 0,
	    		'notshipped_value' => 0,
	    		'cancelled_value' => 0,
	    		'all_value'  => 0,
	    		'failed'  		=> 0,
	    		'delivered_percentage' => 0,
	    		'shipped_percentage' => 0
	    	];
        }


        // Most Ordered States
        $customers = Customers::distinct('state')->where('business_id', auth()->id())->get();
        $states = [];

        foreach($customers as $c) {
            // get total orders for that state
            $sales[] = Orders::where('customer_id', $c->id)->first()->product_total_price;

            $states[] = ['state' => $c->state, 'count' => Customers::where('state', $c->state)->where('business_id', auth()->id())->count(), 'sales' => array_sum($sales)];
        }

        $most_ordered_states = array_slice($states, 0, 5);

        $data['most_ordered_states'] = $most_ordered_states;

        // Top Selling Products;
        $forms = Forms::where('business_id', auth()->id())->get();
        $products = [];

        foreach($forms as $item) {
            if($item->views >= 50) {
                $sales = [];
                foreach(json_decode($item->products) as $i) {

                    $sales[] = Orders::where('product_id', $i)->sum('product_total_price');
                }

                $products[] = ['products' => $item->products, 'views' => $item->views, 'link' => $item->link, 'sales' => array_sum($sales)];
            }
        }

        $top_selling_products = array_slice($products, 0, 5);

        $data['top_selling_products'] = $top_selling_products;

        // Frequent Customers
        $frequent_customers = [];
        $frequent_c = \DB::table('customers')->distinct('phonenumber')->where('business_id', auth()->id())->get();

        foreach ($frequent_c as $customer) {
            $frequent_customers[] = ['phonenumber' => $customer->phonenumber, 'ocurrence' => Customers::where('phonenumber', $customer->phonenumber)->count(), 'total_order' => Orders::where('customer_id', $customer->id)->count(), 'total_order_amount' => Orders::where('customer_id', $customer->id)->sum('product_total_price')];
        }

        $frequent_customers_count = array_slice($frequent_customers, 0, 5);

        $data['frequent_customers_count'] = $frequent_customers_count;

        return view('reports.index', $data);
    }

    public function revenue(Request $request) {

        $Orders = Orders::all();
        $dateFilter = '';

        if($request->get('filter')) {
            $filter = $request->filter;

            switch ($filter) {
                case 'today':
                    # code...
                    $dateFilter = Carbon::today();

                    break;

                case 'yesterday':
                    # code...
                    $dateFilter = Carbon::yesterday();

                    break;

                case 'last7days':
                    # code...
                    $dateFilter = Carbon::now()->subDays(7);

                    break;

                case 'last30days':
                    # code...
                    $dateFilter = Carbon::now()->subDays(30);
                    break;

                case 'lastmonth':
                    # code...
                    $dateFilter = Carbon::now()->subMonth();

                    break;
                
                default:
                    # code...
                    $dateFilter = Carbon::now()->subMonth();
                    break;
            }


            $orders_counted = Orders::whereDate('created_at', $dateFilter)->where('business_id', auth()->id())->count();

            $total_orders_delivered = Orders::whereDate('created_at', $dateFilter)->where('delivery_status', 'delivered')->where('business_id', auth()->id())->get();

            $total_new_orders =  Orders::whereDate('created_at', $dateFilter)->where('delivery_status', 'New Order')->where('business_id', auth()->id())->get();

            $total_orders =  Orders::whereDate('created_at', $dateFilter)->where('business_id', auth()->id())->get();

            $total_orders_shipped =   Orders::whereDate('created_at', $dateFilter)->where('delivery_status', 'shipped')->where('business_id', auth()->id())->get();

            $total_orders_not_shipped =   Orders::whereDate('created_at', $dateFilter)->where('delivery_status', 'notshipped')->where('business_id', auth()->id())->get();

            $total_orders_cancelled =   Orders::whereDate('created_at', $dateFilter)->where('delivery_status', 'cancelled')->where('business_id', auth()->id())->get();

            $total_orders_rescheduled =  Orders::whereDate('created_at', $dateFilter)->where('delivery_status', 'rescheduled')->where('business_id', auth()->id())->get();

            $total_orders_pending =  Orders::whereDate('created_at', $dateFilter)->where('delivery_status', 'pending')->where('business_id', auth()->id())->get();

            $total_orders_refunded =  Orders::whereDate('created_at', $dateFilter)->where('delivery_status', 'refunded')->where('business_id', auth()->id())->get();

            $total_orders_remitted =  Orders::whereDate('created_at', $dateFilter)->where('delivery_status', 'Payment Received')->where('business_id', auth()->id())->count();

            $total_orders_ready =  Orders::whereDate('created_at', $dateFilter)->where('delivery_status', 'Ready for Delivery')->where('business_id', auth()->id())->get();

            $total_orders_failed =  Orders::whereDate('created_at', $dateFilter)->where('delivery_status', 'failed')->where('business_id', auth()->id())->get();

            $orders_in_transit =   Orders::whereDate('created_at', $dateFilter)->where('delivery_status', 'shipped')->where('business_id', auth()->id())->count();

            $orders_notin_transit =   Orders::whereDate('created_at', $dateFilter)->where('delivery_status', 'notshipped')->where('business_id', auth()->id())->count();

            $orders_delivered =  Orders::whereDate('created_at', $dateFilter)->where('delivery_status', 'delivered')->where('business_id', auth()->id())->count();


            $shipped_value =  Orders::whereDate('created_at', $dateFilter)->where('business_id', auth()->id())->get();

            // $delivered_percentage =  $Orders
            // ->where('delivery_status', 'delivered')
            // ->count() / @Orders::all()->count() * 100;

            // $shipped_percentage =  $Orders
            // ->where('delivery_status', 'shipped')
            // ->count() / @Orders::all()->count() * 100;

            $failed =  Orders::whereDate('created_at', $dateFilter)
            ->where('delivery_status', 'cancelled')
            ->where('business_id', auth()->id())->count();

            $total_orders_followup =  Orders::whereDate('created_at', $dateFilter)
            ->where('delivery_status', 'followup')
            ->where('business_id', auth()->id())->get();

            $total_orders_deleted = Orders::whereDate('created_at', $dateFilter)
            ->where('delivery_status', 'deleted')
            ->where('business_id', auth()->id())->get();

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

                $delivered_chart_data[] =  Orders::whereDate('created_at', $dateFilter)->where('delivery_status', 'delivered')->where('business_id', auth()->id())->count();

                $in_transit_chart_data[] =  Orders::whereDate('created_at', $dateFilter)->where('delivery_status', 'shipped')->where('business_id', auth()->id())->count();

                $cancelled_chart_data[] =  Orders::whereDate('created_at', $dateFilter)->where('delivery_status', 'cancelled')->where('business_id', auth()->id())->count();

                $rescheduled_chart_data[] =  Orders::whereDate('created_at', $dateFilter)->where('delivery_status', 'rescheduled')->where('business_id', auth()->id())->count();

                $pending_chart_data[] =  Orders::whereDate('created_at', $dateFilter)->where('delivery_status', 'pending')->where('business_id', auth()->id())->count();

                $refunded_chart_data[] =  Orders::whereDate('created_at', $dateFilter)->where('delivery_status', 'refunded')->where('business_id', auth()->id())->count();
            }

        } else {
            $currentMonth = date('m');

    		$Orders = Orders::whereRaw('MONTH(created_at) = ?',[$currentMonth]);

            $orders_counted = DB::table('orders')->whereRaw('MONTH(created_at) = ?', [$currentMonth])->where('delivery_status', 'New Order')->where('business_id', auth()->id())->count();

            $month_orders_array = DB::table('orders')->whereMonth('created_at', [$currentMonth])->where('business_id', auth()->id())->get();

    		$total_orders_delivered =  DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
            ->where('delivery_status', 'delivered')
            ->where('business_id', auth()->id())->get();

            $total_orders =  DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
            ->where('business_id', auth()->id())->get();

            $total_new_orders = DB::table('orders')->whereRaw('MONTH(created_at) = ?', [$currentMonth])->where('delivery_status', 'New Order')->where('business_id', auth()->id())->get();

            $total_orders_shipped = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])->where('delivery_status', 'shipped')
            ->where('business_id', auth()->id())->get();

            $total_orders_not_shipped = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])->where('delivery_status', 'notshipped')
            ->where('business_id', auth()->id())->get();

            $total_orders_rescheduled = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])->where('delivery_status', 'rescheduled')
            ->where('business_id', auth()->id())->get();

            $total_orders_cancelled = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])->where('delivery_status', 'cancelled')
            ->where('business_id', auth()->id())->get();

            $total_orders_pending = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])->where('delivery_status', 'pending')
            ->where('business_id', auth()->id())->get();

            $orders_in_transit = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
            ->where('delivery_status', 'shipped')
            ->where('business_id', auth()->id())->count();

            $orders_notin_transit = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
            ->where('delivery_status', 'notshipped')
            ->where('business_id', auth()->id())->count();

            $orders_delivered = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
            ->where('delivery_status', 'delivered')
            ->where('business_id', auth()->id())->count();

            $shipped_value = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
            ->where('business_id', auth()->id())->count();

            $orders_rescheduled = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
            ->where('delivery_status', 'rescheduled')
            ->where('business_id', auth()->id())->count();

            $orders_pending = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
            ->where('delivery_status', 'pending')
            ->where('business_id', auth()->id())->count();

            $orders_refunded = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
            ->where('delivery_status', 'refunded')
            ->where('business_id', auth()->id())->count();

            $orders_cancelled = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
            ->where('delivery_status', 'cancelled')
            ->where('business_id', auth()->id())->count();

            $orders_shipped = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
            ->where('delivery_status', 'shipped')
            ->where('business_id', auth()->id())->count();

            $orders_notshipped = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
            ->where('delivery_status', 'notshipped')
            ->where('business_id', auth()->id())->count();

            $total_orders_refunded = DB::table("orders")
            ->where('delivery_status', 'refunded')
            ->where('business_id', auth()->id())->get();

            $total_orders_remitted = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])->where('delivery_status', 'Payment Received')
            ->where('business_id', auth()->id())->get();

            $total_orders_ready = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])->where('delivery_status', 'Ready for Delivery')
            ->where('business_id', auth()->id())->get();

            $total_orders_failed = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])->where('delivery_status', 'failed')
			->where('business_id', auth()->id())->get();

			$total_orders_followup = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])->where('delivery_status', 'followup')
            ->where('business_id', auth()->id())->get();

			$total_orders_deleted = DB::table("orders")
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])->where('delivery_status', 'deleted')
            ->where('business_id', auth()->id())->get();


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
            ->where('business_id', auth()->id())->count();


            $delivered_chart_data = [

			];

			$in_transit_chart_data = [];

			$cancelled_chart_data = [];

			$timestamp = strtotime('this year');
			$days = array();

			for ($i = 0; $i < 12; $i++) {
			    $days[] = strftime('%A', $timestamp);
			    $timestamp = strtotime('-1 month', $timestamp);

			    $currentMonth = date('m');

                $orders_chart[] = Orders::whereRaw('MONTH(created_at) = ?',[$currentMonth])->where('business_id', auth()->id())->count();

			    $delivered_chart_data[] = Orders::whereRaw('MONTH(created_at) = ?',[$currentMonth])->where('delivery_status', 'delivered')->where('business_id', auth()->id())->count();

			    $in_transit_chart_data[] = Orders::whereRaw('MONTH(created_at) = ?',[$currentMonth])->where('delivery_status', 'shipped')->where('business_id', auth()->id())->count();

			    $cancelled_chart_data[] = Orders::whereRaw('MONTH(created_at) = ?',[$currentMonth])->where('delivery_status', 'cancelled')->where('business_id', auth()->id())->count();

			    $rescheduled_chart_data[] = Orders::whereRaw('MONTH(created_at) = ?',[$currentMonth])->where('delivery_status', 'rescheduled')->where('business_id', auth()->id())->count();

			    $pending_chart_data[] = Orders::whereRaw('MONTH(created_at) = ?',[$currentMonth])->where('delivery_status', 'pending')->where('business_id', auth()->id())->count();

				$refunded_chart_data[] = Orders::whereRaw('MONTH(created_at) = ?',[$currentMonth])->where('delivery_status', 'refunded')->where('business_id', auth()->id())->count();

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

            $orders_new = count($total_new_orders);

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
                'orders_new'  => $orders_new,
                'new_value' => $new_values,
                'failed'    => Orders::whereRaw('MONTH(created_at) = ?',[$currentMonth])->where('delivery_status', 'cancelled')->count(),
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

        return view('revenue.index', $data);
    }
}
