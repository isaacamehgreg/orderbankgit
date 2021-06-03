<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\PasswordResets;
use Illuminate\Support\Str;
use App\User;
use Illuminate\Http\Request;
use DB;
use Hash;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */
    
    public function index() {
	    return view('forgot-password');
    }
    
    public function post(Request $request) {
	    $request->validate([
		   'email_address' => ['required', 'exists:users']
	    ]);
	    
	    $email_address = $request->email_address;
	    
	    // find user
	    $user = User::where('email_address', $email_address)->first();
	    
	    // create token
	    $token = Str::random(10);
	    
	    DB::table('password_resets')->insert([
		   'email' => $email_address,
		   'token' => $token,
		   'expires_at' => strtotime("+30 minutes")
	    ]);
	    
	    $url = url('forgot-password/'.$token);
	    
	    $message = 'Hello '.$user->firstname.' you requested for a password reset, follow this link below to reset your password or ignore it if you did not request for this. Click the link below to reset your password: '.$url;
	    
	    // send mail
	    $this->sendRawMail($email_address, $message, 'Password Reset | OrderBank');
	    
	    return redirect('/')->with('success', 'Password Reset Email Sent.');
    }
    
    public function verify($token) {
	    $reset = PasswordResets::where('token', $token)->first();
	    
	    if(!$reset) {
		    return redirect('/')->with('error', 'Token is invalid.');
	    }
	    
	    if (time() > $reset->expires_at) {
		    return redirect('/')->with('error', 'Token has expired.');
	    }
	    
	    // find user
	    $user = User::where('email_address', $reset->email)->first();
	    
	    if (!$user) {
		    return redirect('/')->with('error', 'Token has expired.');
	    }
	    
	    return view('change-password');
	    
    }
    
    public function verifyPost(Request $request, $token) {
	    
	    $request->validate([
		   'password' => ['required', 'confirmed'],
	    ]);
	    
	    $reset = PasswordResets::where('token', $token)->first();
	    
	    // find user
	    $user = User::where('email_address', $reset->email)->first();
		$user->password = Hash::make($request->password);
		$user->save();
		
		$reset->delete();
	    
	    return redirect('/')->with('success', 'Password Changed Successfully.');
	    
    }

}
