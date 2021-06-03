<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{

    public function all() {
    	$users = User::where('business_id', auth()->id())->get();

    	return view('users.all', ['users' => $users]);
    }

    public function add_user() {
    	return view('users.add');
    }

    public function add_user_post(Request $request) {
    	$validation = Validator::make($request->all(), [
    		'role' => 'required',
    		'firstname' => 'required',
    		'lastname' => 'required',
    		'email_address' => 'required|unique:users',
    		'phone_number' => 'nullable',
    		'address' => 'nullable' 
    	]);

    	if($validation->fails()) {
    		return back()->withErrors($validation);
    	} else {

    		$user = new User();
    		$user->business_id = auth()->id();
    		$user->role = $request->input('role');
    		$user->firstname = $request->input('firstname');
    		$user->lastname = $request->input('lastname');
    		$user->email_address = $request->input('email_address');
    		$user->password = Hash::make($request->password);
    		$user->address = $request->address;
    		$user->phone_number = $request->phone_number;
    		$user->save();

    		return back()->with('success', 'User added!');
    	}
    }

    public function edit_user($id) {
    	$user = User::find($id);
    	return view('users.edit', ['user' => $user]);
    }

    public function edit_user_post(Request $request, $id) {
    	$validation = Validator::make($request->all(), [
    		'role' => 'required',
    		'firstname' => 'required',
    		'lastname' => 'required',
    		'email_address' => 'required',
    		'phone_number' => 'nullable',
    		'address' => 'nullable' 
    	]);

    	if($validation->fails()) {
    		return back()->withErrors($validation);
    	} else {

    		$user = User::find($id);
    		$user->role = $request->input('role');
    		$user->firstname = $request->input('firstname');
    		$user->lastname = $request->input('lastname');
    		$user->email_address = $request->input('email_address');
    		$user->address = $request->address;
    		$user->phone_number = $request->phone_number;
    		$user->save();

    		return back()->with('success', 'User modified!');
    	}
    }

    public function reset_user($id) {
    	$user = User::find($id);

    	// Generate new password
    	$new_password = str_random(10);

    	// Hash it
    	$hashed_password = Hash::make($new_password);

    	// Update it
    	$user->password = $hashed_password;
    	$user->save();

    	// Mail it

    	// Return success
    	return back()->with('success', "Password reset done, user should check their email inbox for new password");

    }

    public function disable_user($id) {
    	$user = User::find($id);

    	$user->disabled = 'yes';

    	$user->save();

    	return back()->with('success', "User has been disabled");
    }

    public function enable_user($id) {
    	$user = User::find($id);

    	$user->disabled = 'no';

    	$user->save();

    	return back()->with('success', "User has been enabled");
    }

    public function delete_user($id) {
        $user = User::find($id);

        $user->delete();

        return back()->with('success', "User has been deleted");
    }
}
