<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Business;
use App\Subscriptions;
use App\Wallet;
use App\User;
use App\Products;
use Auth;
use Carbon\Carbon;

use Validator;

class BusinessController extends Controller
{
    public function index() {
    	$check = Business::where('user_id', auth()->id())->count();

    	if ($check == 0):
    		return redirect('/business/add');
    	endif;

    	$business = Business::where('user_id', auth()->id())->first();
    	return view('business.index', ['business' => $business]);
    }

    public function post(Request $request) {
    	$request->validate([
    		'business_name' 		=> ['required'],
    		'business_address' 		=> ['required'],
    		'business_phone_number' => ['required']
    	]);

    	$business = Business::where('user_id', auth()->id())->first();
		$business->business_name = $request->business_name;
		$business->business_email = $request->business_email;
    	$business->business_address = $request->business_address;
    	$business->business_phone_number = $request->business_phone_number;
    	$business->save();

    	return back()->with('success', 'Success');
    }

    public function add() {
    	return view('business.add');
    }

    public function addPost(Request $request) {
    	$request->validate([
    		'business_name' 		=> ['required'],
    		'business_address' 		=> ['required'],
    		'business_phone_number' => ['required']
    	]);

    	$business = new Business();
    	$business->user_id = auth()->id();
		$business->business_name = $request->business_name;
		$business->business_email = $request->business_email;
    	$business->business_address = $request->business_address;
    	$business->business_phone_number = $request->business_phone_number;
    	$business->save();

    	return redirect('/business')->with('success', 'Added!');
    }

    public function upload_dp(Request $request) {
    	$validation = Validator::make($request->all(), [
    		'file' => 'required | mimes:png,jpeg,jpg,png | max:1000',
    	]);

    	if($validation->fails()) {
    		return back()->withErrors($validation);
    	} else {

    		$file = $request->file('file');
    		$dir = public_path('images');
    		$new_name = md5('orderbank').time().$file->getClientOriginalExtension();
    		$file->move($dir, $new_name);

    		$id = \auth()->user()->id;

    		$business = Business::where('user_id', auth()->id())->first();
    		$business->business_logo = 'images/'.$new_name;
    		$business->save();

    		return back()->with('success', 'Business logo modified!');
    	}
    }

    public function all() {
        $user = Auth::user();
        $users = [];
        $subscription = Subscriptions::orderBy('created_at', 'desc')->get();
        $wallet = Wallet::orderBy('created_at', 'desc')->get();
        $businesses = Business::orderBy('created_at', 'desc')->get();
        return view('business.view')->with(['businesses' => $businesses, 'subscription' => $subscription, 'wallet' => $wallet, 'users' => $users]);
    }

    public function liveStatus($user_id)
    {
        $user = User::find($user_id);
        if (Cache::has('user-is-online-' . $user->id))
            $status = 'Online';
        else
            $status = 'Offline';
        if ($user->last_seen != null)
            $last_seen = "Active " . Carbon::parse($user->last_seen)->diffForHumans();
        else
            $last_seen = "No data";
        return response()->json([
            'status' => $status,
            'last_seen' => $last_seen,
        ]);
    }

    public function access($id)
    {
        $business = Business::where('id', $id)->first();
        $product = Products::where('business_id', $id)->get();
        $subscription = Subscriptions::where('id', $id)->first();

        return view('business.access')->with('businesses', $business)
                                    ->with('products', $product)
                                    ->with('subscriptions', $subscription);
    }

    public function access_kill($id)
    {
        $product = Products::where('id', $id)->first();

        $product->forceDelete();

        return redirect()->back();
    }

    public function access_destroy($id)
    {
        $business = Business::where('id', $id)->first();

        $business->forceDelete();

        return redirect()->back();
    }
}
