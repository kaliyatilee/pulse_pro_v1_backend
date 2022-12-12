<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mockery\Exception;
use Illuminate\Support\Facades\Http;
use DB;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\URL;

class StoreController extends Controller
{

    public function redeem(Request $request) {
        $this->validate($request, [
            'user_id' => ['required'],
            'product_id' => ['required'],
        ]);
        $user = User::find($request->user_id);
        $product = Reward::find($request->product_id);
        $wallet = floatval($user->coins);
        $cost = floatval($product->pulse_points);
        $phone = $user->phone;

        $merchant = DB::table("merchant")->where("id",1)->first();
        if ($wallet < $cost) {
            return response('not enough coins', 403);
        }
        if ($phone === '' || $phone === null) {
            return response('member has not specified phone number, please add you mobile number in your profile', 403);
        }

        $transaction = Transaction::create([
            'user_id' => $request->user_id,
            'reward_id' => $request->product_id,
            'transaction_id' => 'pending',
            'redeem_key' => 'pending',
            'price' => $cost,
            'status' => 'pending'
        ]);
        $transaction_id = strtoupper($this->generate_uuid());
        $redeemCode = strtoupper("PH-" . Str::random(6));
        $user->loyaltpoints = $wallet - $cost;
        if ($user->save()) {
            $transaction->status = 'paid';
            $transaction->transaction_id = $transaction_id;
            $transaction->redeem_key = Hash::make($redeemCode);
        }
        if ($transaction->save()) {
            $product->amount = $product->amount - 1;
        }
        $product->save();
        $otp = $redeemCode;

        $message = "Pulse Wellness: Your redeem code is: ".urlencode($otp).". You can collect your product at any ". $merchant->name . " outlet.";

        $smsbaseurl = "http://portal.bulksmsweb.com/index.php?app=ws&u=astrocredit&h=6b46a270fc77b3bc63c9ed6863e4635e&op=pv&" ."to=".urlencode(str_replace("+","",$phone))."&msg=".$message;

        $getOtp = Http::post($smsbaseurl)->body();
        return response($getOtp, 200);
    }

    public function checkRedeemCode(Request $request) {
        $this->validate($request, [
            'user_id' => ['required'],
            'redeem_key' => ['required'],
        ]);

        $code = $request->redeem_key;
        $transaction_id = strtok($code, '-');
        $isCodeCorrect = false;

        try {
            $transaction = Transaction::where('transaction_id', $transaction_id)
                ->where('user_id', $request->user_id)->get()->toArray();

            if ($transaction)
                $isCodeCorrect = Hash::check($code, $transaction[0]['redeem_key']);
        } catch (Exception $e) {
            return response($e->getMessage());
        }

        if (!$isCodeCorrect)
            return response("Invalid Redeem Code", 403);

        

        return response("Success", 200);

    }

    public function redeemAPI(Request $request) {
        $this->validate($request, [
            'user_id' => ['required'],
            'product_id' => ['required'],
        ]);
        $user = User::find($request->user_id);
        $product = Reward::find($request->product_id);

        $wallet = floatval($user->loyaltpoints);
        $cost = floatval($product->pulse_points);
        $phone = $user->phone;

        $merchant = DB::table("merchant")->where("id",1)->first();
        if ($wallet < $cost) {
            //return response('not enough coins', 403);

            $response = json_encode(array("status" => "false", "message" => "not enough coins"));
            return response($response, 200);   
        }
        if ($phone === '' || $phone === null) {
            //return response('member has not specified phone number, please add you mobile number in your profile', 403);

            $response = json_encode(array("status" => "false", "message" => "member has not specified phone number, please add you mobile number in your profile"));
            return response($response, 200); 
        }

        $transaction = Transaction::create([
            'user_id' => $request->user_id,
            'reward_id' => $request->product_id,
            'transaction_id' => 'pending',
            'redeem_key' => 'pending',
            'price' => $cost,
            'status' => 'pending'
        ]);
        $transaction_id = strtoupper($this->generate_uuid());
        $redeemCode = strtoupper("PH-" . Str::random(6));
        $user->loyaltpoints = $wallet - $cost;
        if ($user->save()) {
            //$transaction->status = 'paid';
            $transaction->transaction_id = $transaction_id;
            // $transaction->redeem_key = Hash::make($redeemCode);
            $transaction->redeem_key = $redeemCode;
        }
        if ($transaction->save()) {
            //$product->amount = $product->amount - 1;
        }
        $product->save();
        $otp = $redeemCode;

        $message = "Pulse Wellness: Your redeem code is: ".urlencode($otp).". You can collect your product at any ". $merchant->name . " outlet.";

        $smsbaseurl = "http://portal.bulksmsweb.com/index.php?app=ws&u=astrocredit&h=6b46a270fc77b3bc63c9ed6863e4635e&op=pv&" ."to=".urlencode(str_replace("+","",$phone))."&msg=".$message;

        //$getOtp = Http::post($smsbaseurl)->body();
        //return response($getOtp, 200);

        $response = json_encode(array("status" => "true", "redeem_key"=>$otp, "message" => $message));
        return response($response, 200);    
    }

    public function checkRedeemCodeAPI(Request $request) {
        $this->validate($request, [
            'user_id' => ['required'],
            'redeem_key' => ['required'],
        ]);

        $code = $request->redeem_key;
        $transaction_id = strtok($code, '-');
        $isCodeCorrect = false;

        try {
            $transaction = Transaction::where('transaction_id', $transaction_id)
                ->where('user_id', $request->user_id)->get()->toArray();

            if ($transaction)
                $isCodeCorrect = Hash::check($code, $transaction[0]['redeem_key']);
        } catch (Exception $e) {
            //return response($e->getMessage());
            $response = json_encode(array("status" => "false", "message" => $e->getMessage()));
            return response($response, 200);
        }

        if (!$isCodeCorrect){
            $response = json_encode(array("status" => "false", "message" => "Invalid Redeem Code"));
            return response($response, 200);
        }
            //return response("Invalid Redeem Code", 403);

        //return response("Success", 200);
        $response = json_encode(array("status" => "true", "message" => "Sucess"));
        return response($response, 200);
    }

    private function generate_uuid()
    {
        return sprintf( '%04x%04x-%04x',
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
            mt_rand( 0, 0xffff )
        );

    }
}
