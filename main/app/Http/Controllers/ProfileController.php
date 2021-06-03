<?php

namespace App\Http\Controllers;

use App\Helpers\Banks;
use App\Models\BankDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator;
use App\User;
use Hash;
class ProfileController extends Controller
{
    public function profile() {
        $user = auth()->user();
    	return view('profile.profile', [
    	    'profile' => \auth()->user(),
            'banks' => Banks::BANK_CODES,
            'bank_info' => $user->currentBankDetails()
        ]);
    }

    public function update_account_post(Request $request) {
    	$validation = Validator::make($request->all(), [
    		'firstname' => 'required',
    		'lastname' => 'required',
    		'email_address' => 'required',
    		'phone_number' => 'nullable',
    		'address' => 'required'
    	]);

    	if($validation->fails()) {
    		return back()->withErrors($validation);
    	} else {

    		$id = \auth()->user()->id;

    		$user = User::find($id);
    		$user->firstname = $request->input('firstname');
    		$user->lastname = $request->input('lastname');
    		$user->email_address = $request->input('email_address');
    		$user->address = $request->address;
    		$user->business_phone_number = $request->phone_number;
    		$user->save();

    		return back()->with('success', 'Account modified!');
    	}
    }

    public function change_password(Request $request) {
    	$validation = Validator::make($request->all(), [
    		'current_password' => 'required',
    		'new_password' => 'required',
    	]);

    	$validation->after(function($validation) use($request) {
    		if($request->current_password != '' AND !Hash::check($request->current_password, \auth()->user()->password)) {
    			$validation->errors()->add('current_password', 'Current password is incorrect');
    		}
    	});

    	if($validation->fails()) {
    		return back()->withErrors($validation);
    	} else {

    		$id = \auth()->user()->id;

    		$user = User::find($id);
    		$user->password = Hash::make($request->input('new_password'));
    		$user->save();

    		return back()->with('success', 'Password modified!');
    	}
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
    		$new_name = md5('pm').time().$file->getClientOriginalExtension();
    		$file->move($dir, $new_name);

    		$id = \auth()->user()->id;

    		$user = User::find($id);
    		$user->profile_picture_uri = 'images/'.$new_name;
    		$user->save();

    		return back()->with('success', 'Profile picture modified!');
    	}
    }

    public function update_bank_info(Request $request) {
        $validation = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'account_number' => 'string|required',
            'bank_code' => 'string|required',
            'account_name' => 'string'
        ]);
        if ($validation->fails()) {
            return back()->withErrors($validation);
        }
        try {
            $user = auth()->user();
            // resolve the info again since we can't exactly trust what's coming from the frontend
            $accountInfo = Banks::resolveAccountInfo($request->get('account_number'), $request->get('bank_code'));
            $bankDetails = new BankDetails([
                'user_id' => $user->id,
                'nuban' => $accountInfo['account_number'],
                'account_name' => $accountInfo['account_name'],
                'bank_code' => $request->get('bank_code'),
            ]);

            $recipient = Banks::createTransferRecipient(
                $bankDetails->nuban,
                $bankDetails->account_name,
                $bankDetails->bank_code
            );

            Log::info(json_encode($bankDetails, JSON_PRETTY_PRINT));
            $bankDetails->recipient_code = $recipient['recipient_code'];
            $bankDetails->save();
            return back()->with('success', 'Bank details have been updated');
        } catch (\Exception $e) {
            Log::error($e);
            return back()->with('error', $e->getMessage());
        }
    }
}
