<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payments;
use Validator;

class PaymentsController extends Controller
{
    public function all() {
    	return view('payments.all', ['payments' => Payments::all()]);
    }

    public function add() {
    	return view('payments.add');
    }

    public function addPost(Request $request) {
    	$validation = Validator::make($request->all(), [
    		'amount' => 'required',
    	]);

    	if($validation->fails()) {
    		return back()->withErrors($validation);
    	} else {

    		$id = \auth()->user()->id;

    		$payments = new Payments();
            $payments->business_id = auth()->id();
    		$payments->user_id = $id;
    		$payments->amount = $request->amount;
    		$payments->save();

    		return back()->with('success', 'Payment added!');
    	}
    }

    public function edit($id) {
    	return view('payments.edit', ['payments' => Payments::find($id)]);
    }

    public function editPost(Request $request, $id) {
    	$validation = Validator::make($request->all(), [
    		'amount' => 'required',
    	]);

    	if($validation->fails()) {
    		return back()->withErrors($validation);
    	} else {

    		$id = \auth()->user()->id;

    		$payments = Payments::find($id);
    		$payments->user_id = $id;
    		$payments->amount = $request->amount;
    		$payments->save();

    		return back()->with('success', 'Payment added!');
    	}
    }

    public function delete($id) {
    	$payments = Payments::find($id);
    	$payments->delete();

    	return back()->with('success', 'Payment deleted!');
    }
}
