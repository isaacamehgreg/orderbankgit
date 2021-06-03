<?php
namespace App\Http\Controllers;

use App\Models\Referral;
use App\Models\ReferralEarning;
use Illuminate\Support\Facades\Log;

class ReferralsController extends Controller
{
    public function index() {
        $user = auth()->user();
        $referredUsers = Referral::with('referred')
            ->where('referrer_id', $user->id)
            ->orderBy('id', 'desc')->get();
        $totalEarnings = ReferralEarning::where('referrer_id', $user->id)
            ->sum('amount_earned');
        $referredUsersCount = count($referredUsers);
        $data = [
            'referral_code' => $user->referral_code,
            'num_referred_users' => $referredUsersCount,
            'referred_users' => $referredUsers,
            'total_earnings' => round($totalEarnings, 2)
        ];
        return view('referral.index', $data);
    }

    public function generateCode() {
        try {
            $user = auth()->user();
            $hash = hash('sha256', $user->id);
            $ref = substr($hash, 0, 8);
            $user->update(['referral_code' => $ref]);
            return redirect('/referral');
        }
        catch (\Exception $e) {
            Log::error($e);
            return back()->with('error', "Could not generate a code for you at the moment. Please try later.");
        }
    }
}
