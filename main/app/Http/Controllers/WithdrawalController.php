<?php
namespace App\Http\Controllers;

use App\Helpers\Banks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class WithdrawalController extends Controller
{
    public function getBankInfo(Request $request) {
        $validator = Validator::make($request->all(), [
            'nuban' => 'string|required',
            'bank_code' => 'string|required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => "Please select a bank and fill your account info"
            ]);
        }
        try {
            $info = Banks::resolveAccountInfo($request->get('nuban'), $request->get('bank_code'));
            return response()->json([
                'success' => true,
                'data' => $info
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
