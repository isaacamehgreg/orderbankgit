<?php
namespace App\Models;

use App\Wallet;
use App\WalletHistory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class ReferralEarning extends Model
{
    protected $fillable = ['referrer_id', 'origin_transaction_id', 'reference',
        'description', 'amount_earned'];
    const BONUS_PERCENTAGE = 2.5;

    public static function creditReferrer($userId, WalletHistory $transaction) {
        $referral = Referral::where('user_id', $userId)->first();
        if ($referral == null) {
            return;
        }
        $amount = floor(($transaction->amount * self::BONUS_PERCENTAGE) / 100);
        $reference = str_random(12);
        try {
            $bonusTxn = new WalletHistory([
                'user_id' => $referral->referrer_id,
                'reference' => $reference,
                'type' => 'credit',
                'amount' => (string)$amount,
                'status' => Wallet::STATUS_SUCCESSFUL,
                'gateway' => "Referral Bonus"
            ]);
            $bonusTxn->save();

            $earning = new ReferralEarning([
                'referrer_id' => $referral->referrer_id,
                'origin_transaction_id' => $transaction->id,
                'description' => "Referral bonus",
                'reference' => $reference,
                'amount_earned' => $amount
            ]);
            $earning->save();

            $wallet =  Wallet::where('user_id', $referral->referrer_id)->first();
            $wallet->balance = ($wallet->balance + $bonusTxn->amount);
            $wallet->save();
        } catch (\Exception $e) {
            // this shouldn't halt the process so just log it
            Log::error($e);
        }
    }
}
