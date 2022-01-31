<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\History;
use App\Models\Refer;
use App\Models\PasswordReset;
use App\Models\Manage;
use Illuminate\Auth\Events\Registered;
use Hash;
use Validator;
use Auth;
// use App\Models\Ethereum\Ethereum;
include 'Ethereum.php';

class RegisterController extends Controller
{
    public function __construct()
    {

    }

    public function signup(Request $request){

        $v = Validator::make($request->all(), [
            'address'   => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => 'required',
            'phone'     => 'required|unique:users',
            'privatekey' => 'required',
            'termsCond' => 'required'
        ]);
       
        if ($v->fails())
        {
            return ['status'=>"mail",'message'=>$v->errors()];
        }

        $check_refer = 0;
        $refer_id = $request->refer_id;
        if($refer_id == 'nft'){
            $refer = User::find(379);
            $refer_id = $refer->id;
            $check_refer = 1;
        } 
        else if($refer_id == 'Ar') {
            $refer_id = 161;
            $check_refer = 1;
        }
        else {
            $refer = User::find($request->refer_id);  //existing users who refered new member
            if($refer){
                $check_refer = 1;
            }else{
                // return ['status'=>"refer", 'message'=>"The refer ID is incorrect"];
            }
        }
        
        $token = base64_encode(random_bytes(64));
        
        $user = new User();
        $user->phone = $request->phone;
        $user->country = $request->country;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->remember_token = $token;
        $user->address = $request->address;
        $user->private = $request->privatekey;
        
        if($request->termsCond)
            $user->termsCond = 'checked';
        
        if($user->save()) {
            // event(new Registered($user));
            if(!$user->email_verified_at) {
                $user->update(['email_token' => bin2hex(openssl_random_pseudo_bytes(4))]);
                $user_email = base64_encode($user->email);
                \Mail::to($request->email)->send(new \App\Mail\EmailVerification($user->email_token, $user_email));
            }
            
            if($check_refer == 1){
                $is_existed_refer = Refer::where('user_id', $refer_id)->where('refer_id', $user->id)->count();
    
                if($is_existed_refer == 0) {
                    $refer = new Refer();
                    $refer->user_id = $refer_id;
                    $refer->refer_id = $user->id;
                    $refer->save();
                }
            }
        }
        
        return ['status'=>"ok", 'token'=>$token];
    }

    public function signin(Request $request){
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = User::where('email', $request->email)->first();

            $user->remember_token = base64_encode(random_bytes(64));
            $user->save();
            
            // if($user->email_verified_at == NULL) {
            //     $user->update(['email_token' => bin2hex(openssl_random_pseudo_bytes(4))]);
            //     \Mail::to($request->email)->send(new \App\Mail\EmailVerification($user->email_token, base64_encode($user->email)));
            //     return ['status'=>"emailVerify", 'verifyToggle'=>$user->email_verify_toggle, 'emailVerified'=>$user->email_verified_at ? true:false];
            // }

            // if($user->email_verified_at != NULL) {
            //     if($user->email_verify_toggle == "checked") {
            //         $user->update(['email_token' => bin2hex(openssl_random_pseudo_bytes(4))]);
            //         \Mail::to($request->email)->send(new \App\Mail\EmailAuthenticate($user->email_token));
            //         return ['status'=>"email", 'verifyToggle'=>$user->email_verify_toggle, 'emailVerified'=>$user->email_verified_at ? true:false];
            //     }
                
            //     if($user->email_verify_toggle !== "checked")
            //         return ['status'=>"success", 'token'=>$user->remember_token, 'verifyToggle'=>$user->email_verify_toggle];
            // }
            if($user->email_verify_toggle == "checked") {
                $user->update(['email_token' => bin2hex(openssl_random_pseudo_bytes(4))]);
                \Mail::to($request->email)->send(new \App\Mail\EmailAuthenticate($user->email_token));
                return ['status'=>"email", 'verifyToggle'=>$user->email_verify_toggle, 'emailVerified'=>$user->email_verified_at ? true:false];
            }
            
            if($user->email_verify_toggle !== "checked")
                return ['status'=>"success", 'token'=>$user->remember_token, 'verifyToggle'=>$user->email_verify_toggle];
        }

        return ['status'=>"error", 'message'=>"Email or password is incorrect."];
    }
    
    public function emailVerify(Request $request) {
        $emailCode = $request->emailCode;
        $email = $request->email;
        $user = User::where('email', $email)->where('email_token', $emailCode)->first();
        if($user) {
            return ['status'=>"success", 'token'=>$user->remember_token];
        }else {
            $email = base64_decode($request->ueecp);
            $user = User::where('email', $email)->where('email_token', $request->swuev)->first();
            
            if($user) {
                $user->update(['email_verified_at' => now()]);
                // $user->update(['email_verified_at' => date("Y-m-d H:i:s")]);
                return ['status'=>'emailVerified', 'message'=>'Email is verified'];
            }

        }
        return ['status'=>"error", 'message'=>"Email or password is incorrect."];
    }
    
    public function emailVerifyToggle(Request $request, $status) {
        $user = User::where('remember_token', $request->token)->first();
        $user->email_verify_toggle = $status == "on" ? "checked" : "";
        $user->save();
    }

    public function forget(Request $request){
        $user = User::where('email', $request->email)->first();
        $token = rand(1000,9999);
        if($user){
            $reset = new PasswordReset();
            $reset->email = $request->email;
            $reset->token =  $token;
            $reset->save();
            $url = "email=".$request->email."=token=".$token;
            $encode_url = rtrim(strtr(base64_encode($url), '+/', '-_'), '=');

            \Mail::to($request->email)->send(new \App\Mail\ForgetPassword($encode_url));
            if (\Mail::failures()) {
                return ['status'=>'error', 'msg'=>'Something went wrong. Please try again!'];
            }
            
            return ['status'=>'success', 'msg'=>'Please check your inbox!'];
        }else{
            return ['status'=>'error', 'msg'=>'Email does not exist'];
        }
    }

    public function token(Request $request){
        $token = $request->token;
        $users = User::where('remember_token', $token)->first();
        if($users){
            $admin = User::where('rol', 1)->first();
            $trans = History::where('user_id', $users->id)->get()->toArray();
            $slam = 0;
            foreach($trans as $temp){
                $slam = $slam+$temp['slam'];
            }
        
            return ['status'=>'ok', 'address'=>$users->address, 'privateKey'=>$users->private, 'email'=>$users->email, 
                'phone'=>$users->phone, 'id'=>$users->id, 'admin'=>$admin->address, 'trans'=>$trans, 'slam'=>intval($slam),
                'name'=> $users->name, 'slamName'=>$users->slam_name, 'tgName'=>$users->tg_name, 'gender' => $users->gender,
                'country' => json_decode($users->country), 'birthday' => $users->birthday, 'place' => $users->place,
                'email_verify_toggle' => $users->email_verify_toggle
            ];
            
        }else{
            return ['status'=>'false', 'message'=>'Something went wrong'];
        }
    }
    
    public function eth_slam(Request $request){
        $v = Validator::make($request->all(), [
            'user_id' => 'required',
            'slamAmount' => 'required',
            'ethAmount' => 'required',
            'txmode' => 'required'
        ]);
       
        $trans = new History();
        $trans->user_id = $request->user_id;
        $trans->slam = $request->slamAmount;
        $trans->eth = $request->ethAmount;
        $trans->bnb = 'ETH';
        if($request->txmode == "send") {
            $trans->bnb = 'ETHOUT';
        }
        $trans->save();
        $this->affiliation($request->user_id, $request->slamAmount);
        $transact = History::where('user_id', $request->user_id)->get()->toArray();
        return ['status'=>'ok', 'trans'=>$transact];
    }
    
    public function bnb_slam(Request $request){
        $v = Validator::make($request->all(), [
            'user_id' => 'required',
            'slamAmount' => 'required',
            'bnbAmount' => 'required', //  slam price at this time
            'txmode' => 'required'
        ]);
        //    db process
        $trans = new History();
        $trans->user_id = $request->user_id;
        $trans->slam = $request->slamAmount;
        $trans->eth = $request->bnbAmount;
        $trans->bnb = 'BNB';
        if($request->txmode == "send") {
            $trans->bnb = 'BNBOUT';
        }
        $trans->save();
        $this->affiliation($request->user_id, $request->slamAmount);
        $transact = History::where('user_id', $request->user_id)->get()->toArray();
        return ['status'=>'ok', 'trans'=>$transact];
    }
    
    public function affiliation($user_id, $slm_amount) {
        //check if he is refered
        $is_refered = Refer::where('refer_id', $user_id)->first();

        if(!empty($is_refered)) {
            $trans = new History();
            $trans->user_id = $is_refered->user_id;
            $trans->slam = $slm_amount*0.03;
            $trans->bnb = "AFFILIATION";
            $trans->save();
        }
    }

    public function reset(Request $request){

        $v = Validator::make($request->all(), [
            'email' => 'email|unique:users,email,'.$request->user_id,
            'phone' => 'unique:users,phone,'.$request->user_id,
            'slamName' => 'unique:users,slam_name,'.$request->user_id,
            'tgName' => 'unique:users,tg_name,'.$request->user_id
        ]);
       
        if ($v->fails())
        {
            return ['status'=>"email",'message'=>$v->errors()];
        }

        $user = User::find($request->user_id);

        if($request->name)
            $user->name  = $request->name;

        if($request->phone)
            $user->phone = $request->phone;
        
        if($request->email && $request->email != $user->email) {
            $user->email_verified_at = NULL;
            $user->email = $request->email;
        }
        
        if($request->slamName)
            $user->slam_name = $request->slamName;

        if($request->tgName)
            $user->tg_name   = $request->tgName;
        
        if($request->birthday)
            $user->birthday = $request->birthday;

        if($request->country)
            $user->country   = $request->country;
        
        if($request->gender)
            $user->gender   = $request->gender;
        
        if($request->place)
            $user->place   = $request->place;
        
        if($request->cpass && $request->npass) {
            if(Hash::check($request->cpass, $user->password)) {
                $user->password = Hash::make($request->npass);
            }else
               return ['status'=>"failure", 'msg'=>'password mismatched'];
        }

        $user->save();

        return ['status'=>"ok", 'msg'=>'success'];
    }

    public function transaction(Request $request){
        $token = $request->token;
        $users = User::where('remember_token', $token)->first();

        if($users){
            $transactions = History::orderBy('id', 'desc')->where('user_id', $users->id)->get();
            $transaction_list  = [];
            foreach($transactions as $transaction) {
                $temp = [];
                $temp['created_at'] = $transaction->created_at->format('Y-m-d H:i:s');

                $temp['method']     = $transaction->bnb;

                if($transaction->bnb == "BNB" || $transaction->bnb == "ETH") {
                    $temp['method']     = "Swap";
                }

                $temp['in_out'] = "IN";
            
                $temp['address'] = $transaction->user ? $transaction->user->address:"Deleted";
                $temp['email'] = $transaction->user ? $transaction->user->email:"Deleted";
                $temp['user_id']   = $transaction->user ? $transaction->user->id: 0;

                $temp['amount']  = abs($transaction->slam);
                $temp['asset'] = "$"."SLM";
                
                $transaction_list[] = $temp;
                if($transaction->bnb == "BNB" || $transaction->bnb == "ETH") {
                    $temp = [];
                    $temp['created_at'] = $transaction->created_at->format('Y-m-d H:i:s');
                    $temp['user_id']   = $transaction->user ? $transaction->user->id: 0;
                    $temp['method']     = "Deposit";
                    $temp["address"]       = $transaction->user ? $transaction->user->address:"Deleted";
                    $temp['email'] = $transaction->user ? $transaction->user->email:"Deleted";
                    
                    $temp['in_out'] = "OUT";
                    $temp['amount']  = abs($transaction->eth);
                    $temp['asset'] = $transaction->bnb;
                    $transaction_list[] = $temp;
                }
            }
            return ['status'=>'ok', 'transactions'=>$transaction_list];
        }else{
            return ['status'=>'false', 'message'=>'Something went wrong'];
        }
    }

    public function verify(Request $request) {
        // var_dump(base64_decode("ZW1haWw9YWRtaW5AZ21haWwuY29tJnRva2VuPTUyNTg"));
        $decode_url = rtrim(strtr(base64_decode($request->decode_url), '+/', '-_'), '=');
        // $decode_url = "email=admin@gmail.com=token=5258";
        $params = explode("=", $decode_url);
        
        if(count($params) == 4)
        {
            $passwordReset = PasswordReset::where('email', $params[1])->where('token', $params[3])->first();
            if($passwordReset) {
                $user = User::where('email', $params[1])->first();
                if(!$user)
                    return ['status' => 'failure', 'message' => 'Something went wrong'];
                
                $user->password = Hash::make($request->password);
                $user->save();
                return ['status' => 'success', 'message' => 'Password is updated successfully'];
            }
            return ['status' => 'failure', 'message' => 'Something went wrong'];
        }    
        
        return ['status' => 'failure', 'message' => 'Please try again'];
    }

    public function currentSoldTokenAmount() {
        $currentSoldAmount = History::whereIn('bnb', ['BNB', 'ETH', 'BONUS', 'DEDUCT'])->pluck('slam')->sum();
        $manage = Manage::first();
        return ['currentSoldAmount' => $currentSoldAmount, 'togglePresalePrice' => $manage->togglePresalePrice,
            'limitTokenPrice' => floatval($manage->limitTokenPrice), 'limitTokenNumber' => floatval($manage->soldAmount)
        ];
    }
    
    public function manages(Request $request) {
        $manage = Manage::first();
        $token_price = $manage->token_price;
        $progressbarToggle = $manage->is_progressbar;
        $currentSoldAmount = History::whereIn('bnb', ['BNB', 'ETH', 'BONUS', 'DEDUCT'])->pluck('slam')->sum();
        // var_dump($currentSoldAmount);
        return [
            'tokenPrice'=> floatval($token_price), 
            'progressbarToggle'=> $progressbarToggle, 
            'blockBuyToggle'=>$manage->is_blockBuy, 
            'countdownToggle'=>$manage->is_countdown, 
            'countDownSec'=> strtotime($manage->countDownDate." ".$manage->countDownTime) - strtotime(now()),
            'presaleEndSec'=> floatval($manage->countDownEndSec),
            'marketCap'=> floatval($manage->market_cap),
            'marketCapOld'=> floatval($manage->market_cap_old),
            'presaleTokenNumber' => floatval($manage->presaleCount),
            'maxMinToggle'  => $manage->is_minmax,
            'currentSoldAmount'    => floatval($currentSoldAmount),
            'limitTokenNumber'    => floatval($manage->soldAmount),
            'limitTokenPrice'=> floatval($manage->limitTokenPrice),
            'togglePresalePrice'=> $manage->togglePresalePrice,
            'maximumExchange'=> floatval($manage->max_bnb_purchase),
            'minimumExchange' => floatval($manage->min_bnb_purchase),
            'maximumExchangeEth'=> floatval($manage->max_eth_purchase),
            'minimumExchangeEth' => floatval($manage->min_eth_purchase),
            'sendToggle' => $manage->sendToggle
        ];
    }

    public function getAffiliations(Request $request) {
        $token = $request->token;
        $users = User::where('remember_token', $token)->first();
        $refers_list = [];
        
        if($users) {
            $refers = Refer::where('user_id', $users->id)->pluck('refer_id')->toArray();
            
            $totalAffiliation = History::where('bnb', 'Affiliation')->where('user_id', $users->id)->pluck('slam')->sum();
            $histories = History::whereIn('user_id', $refers)->get();
            $historyUsers = [];

            foreach($histories as $history) {
                $temp = [];
                if($history->user) {
                    $temp['created_at'] = $history->created_at->format('Y-m-d H:i:s');
                    $temp['amount']   = $history->eth;
                    $temp['currency'] = $history->bnb;
                    $userEmail = explode('@', $history->user->email);
                    $temp['email']   =   $userEmail[0];
    
                    $temp['address'] = $history->user->address;
                    $temp['reward']  = $history->slam*0.03;
                    $historyUsers[] = $history->user->id;
                    $refers_list[] = $temp;
                }
            }
            // var_dump($refers_list);
            $uninvestedUsers = array_diff($refers, $historyUsers);

            if(count($uninvestedUsers) > 0)
                foreach($uninvestedUsers as $tempUserId) {
                    $temp = [];
                    $refer = Refer::where('refer_id', $tempUserId)->first();
                    $user  = User::find($tempUserId);
                    if($user) {
                        $temp['created_at'] = $refer->created_at->format('Y-m-d H:i:s');
                        $temp['amount']   = 0;
                        $temp['currency'] = "";
                        $userEmail = explode('@', $user->email);
                        $temp['email']   =   $userEmail[0];
                        $temp['address'] = $user->address;
                    
                        $temp['reward']  = 0;
                        $refers_list[] = $temp;
                    }
                }
            return ['status' => 'success', 'refers' => $refers_list, 'totalAffiliation' => $totalAffiliation];
        }

    }

    public function progressbarToggle() {
        $manage = Manage::first();
        $token_price = $manage->token_price;
        return $token_price;
    }

    public function resetPasswd(Request $request) {
        $token = $request->token;
        $user = User::where('remember_token', $token)->first();

        if($user && $request->cpass && $request->npass) {
            if(Hash::check($request->cpass, $user->password)) {
                $user->password = Hash::make($request->npass);
                $user->save();
                return ['status'=>"success", 'msg'=>'password updated'];
            }else
                return ['status'=>"failure", 'msg'=>'password mismatched'];
        }
        return ['status'=>"failure", 'msg'=>'There was something wrong!'];
    }

    public function verificationEmail(Request $request) {
        $email = $request->query('email');
        $user  = User::where('email', $email)->first();
        if($user) {
            $user->update(['email_token' => bin2hex(openssl_random_pseudo_bytes(4))]);
            $user_email = base64_encode($email);
            \Mail::to($request->email)->send(new \App\Mail\EmailVerification($user->email_token, $user_email));
    
            if (!\Mail::failures()) 
                return ['status'=>"success", 'msg'=>'Verification email was sent!'];
            
        }
        return ['status'=>"failure", 'msg'=>'There was something wrong!'];
    }

    public function getBnbBalance($wallet_address) {
        $ethereum = new Ethereum('https://bsc-dataseed.binance.org/', 443);
        // try{

        // }catch() {

        // }
        // return "ok";
        return (hexdec($ethereum->eth_getBalance($wallet_address))/pow(10, 18));
    }

    public function getEthBalance($wallet_address) {
        $ethereum = new Ethereum('https://mainnet.infura.io/v3/54fbd839e1614edb89bc979aaf1a069f', 443);
        // return "ok";
        return (hexdec($ethereum->eth_getBalance($wallet_address))/pow(10, 18));
    }
}
