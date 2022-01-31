<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\History;
use App\Models\Refer;
use App\Models\Manage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Carbon\Carbon;
use DB;
// require 'Ethereum/ethereum.php';
use App\Models\Ethereum\Ethereum;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $user = auth()->user();
        $users = User::where('id', '!=', $user->id)->withTrashed()->orderBy('id', 'desc')->get();
        
        return view('admin.index', compact('users', 'user'))->with('active', 'user');
    }

    public function profile($user_id){
        $user = auth()->user();
        $user_data = User::withTrashed()->find($user_id);
        if(!$user_data)
            return back();
            
        return view('admin.profile', compact('user_data', 'user'))->with('active', 'user');
    }

    public function setting(){
        $user = auth()->user();
        $manage = Manage::first();
        
        return view('admin.setting', compact('user', 'manage'))->with('active', 'setting');
    }

    public function destroy($id){
        User::find($id)->delete();
        return back()->with('destroy', 'Deleted Successfully!');
    }

    public function retrieve($id){
        User::withTrashed()->find($id)->restore();
        return back()->with('success', 'Retrieved Successfully!');
    }
    
    public function update(Request $request){
        $email_confirm = User::whereNotIn('id', [auth()->user()->id])->where('email', $request->email)->get();
        if(count($email_confirm)>0){
            return back()->with('destroy', 'The Email is exist already. Please Use other email');
        }
        if($request->cpass !== $request->npass){
            return back()->with('destroy', 'Password is not matched.');
        }

        $user = User::find(auth()->user()->id);
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->address = $request->address;

        $user->name = $request->name;
        $user->slam_name = $request->slam_name;
        $user->tg_name = $request->tg_name;

        if($request->npass){
            $user->password = Hash::make($request->npass);  
        }
        $user->save();

        return back()->with('success', 'Updated Successfully!');
    }
    
    public function bonus(Request $request){
        if(floatval($request->bonus) == null  || !intval($request->user_id) > 0 ){
            return back();
        }

        $trans = new History();
        $trans->user_id = $request->user_id;
        
        if($request->bonus > 0)
            $trans->bnb = "BONUS";
        else
            $trans->bnb = "DEDUCT";
        
        $trans->slam = $request->bonus;
        $trans->save();
        return back()->with('success', 'Sent successfully');
    }

    public function memo_save(Request $request){
        
        $validated = $request->validate([
            'user_id' => 'required',
            'memo' => 'required'
        ]);

        $user = User::find($request->user_id);
        $user->memo = $request->memo;
        $user->save();

        return 'Memo saved successfully';
    }
    
    public function password_update(Request $request){
        
        $validated = Validator::make($request->all(), [
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        $user = User::find($request->user_id);
        $user->password = bcrypt($request->password);
        $user->save();

        return 'Password updated successfully';
    }
    
    public function forceswap(Request $request) 
    {
        $user = User::find($request->user_id);
        // get user info and deduct from the history table

        // add removed funds to admin wallet
        
    }

    public function profile_update(Request $request)
    {
        if($request->password) {
            $validator = Validator::make($request->all(), [
                'password' => ['string', 'min:8', 'confirmed']
            ]);
    
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
        }

        $user = User::find($request->id);
        if($request->name) {
            $user->name = $request->name;
        }
        if($request->slam_name) {
            $user->slam_name = $request->slam_name;
        }
        if($request->tg_name) {
            $user->tg_name = $request->tg_name;
        }

        if($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->save();
        return back()->with('success', 'Saved successfully');
    }

    public function transaction(Request $request)
    {
        $transactions = History::orderBy('id', 'desc')->get();
        
        if($request->query('type') == "transaction" && $request->query('user_id')) {
            $transactions = History::where('user_id', $request->query('user_id'))->orderBy('id', 'desc')->get();
        }
        $transaction_list  = [];
        $totalSLM = History::pluck('slam')->sum();
        $totalBNB = History::where("bnb", 'BNB')->whereNotNull('eth')->sum('eth');
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
        
        $user = auth()->user();
        return view('admin.transaction', compact('transaction_list', 'totalBNB', 'totalSLM'))->with('active', 'transaction');
    }

    public function manage(Request $request) {
        $manage = Manage::first();
        
        if($request->min_bnb_purchase > 0)
            $manage->min_bnb_purchase = $request->min_bnb_purchase;
            
        if($request->max_bnb_purchase > 0)
            $manage->max_bnb_purchase = $request->max_bnb_purchase;
        
        $manage->min_eth_purchase = $request->min_eth_purchase;
        $manage->max_eth_purchase = $request->max_eth_purchase;
        
        if($request->token_price > 0)
            $manage->token_price = $request->token_price;

        $manage->market_cap_old = $manage->market_cap;
        $manage->market_cap     = $request->market_cap;

        if($request->is_progressbar)
            $manage->is_progressbar = "Yes";
        else
            $manage->is_progressbar = "No";

        if($request->is_countdown)
            $manage->is_countdown = "Yes";
        else
            $manage->is_countdown = "No";
        
        if($request->is_blockBuy)
            $manage->is_blockBuy = "Yes";
        else
            $manage->is_blockBuy = "No";
            
        if($request->sendToggle)
            $manage->sendToggle = "Yes";
        else
            $manage->sendToggle = "No";

        if($request->countDownSec)
            $manage->countDownSec = $request->countDownSec;

        $manage->countDownEndSec = $request->countDownEndSec;
            
        if($request->presaleCount)
            $manage->presaleCount = $request->presaleCount;

        if($request->is_minmax)
            $manage->is_minmax = "Yes";
        else
            $manage->is_minmax = "No";
            
        $manage->soldAmount = $request->soldAmount;
        $manage->limitTokenPrice = $request->limitTokenPrice;
        
        $manage->countDownDate = $request->countDownDate;
        $manage->countDownTime = $request->countDownTime;

        if($request->togglePresalePrice)
            $manage->togglePresalePrice = "Yes";
        else
            $manage->togglePresalePrice = "No";
            
        if($manage->save())
            return back()->with('success', 'Saved successfully');
        else
            return back()->with('failure', 'Something went wrong');
    }

    public function affiliation(Request $request) {
        $token = $request->token;
        $refers_list = $historyUsers = [];
        $userList = User::all();
        // $refers = Refer::where('user_id', $users->id)->pluck('refer_id')->toArray();
        $refers = Refer::pluck('refer_id')->toArray();
        
        // $totalAffiliation = array_sum(History::where('bnb', 'AFFILIATION')->pluck('slam')->toArray());
        $totalAffiliation = Refer::all()->count();

        if($request->query('type') == "affiliation" && $request->query('user_id')) {
            // $totalAffiliation = array_sum(History::where('user_id', $request->query('user_id'))->where('bnb', 'AFFILIATION')->pluck('slam')->toArray());
            $totalAffiliation = Refer::where('user_id', $request->query('user_id'))->get()->count();
            $refers = Refer::where('user_id', $request->query('user_id'))->pluck('refer_id')->toArray();
        }
        // dd($refers);
        $histories = History::whereIn('user_id', $refers)->whereIn('bnb', ['ETH', 'BNB'])->where('eth', '>', 0)->get()->reverse();
        // dd($histories);
        foreach($histories as $history) {
            $temp = [];
            $temp['user_id']    = $history->user->id; //refered user
            $temp['created_at'] = $history->created_at->format('Y-m-d H:i:s');
            $temp['email']      = $history->user->email;
            $temp['asset']      = $history->bnb;
            
            $temp['coin_amount'] = $history->eth;
            $temp['amount']     = $history->slam;
            $temp['address']    = $history->user->address;

            $referer_data = $history->user->referer($history->user->id);
            $temp['referer']    = $referer_data ? $referer_data->email: "Not Found";
            $temp['referer_id']    = $referer_data ? $referer_data->id: 0;
            $historyUsers[] = $history->user->id;
            $refers_list[]  = $temp;
        }

        $uninvestedUsers = array_diff($refers, $historyUsers);

        if(count($uninvestedUsers) > 0)
            foreach($uninvestedUsers as $tempUserId) {
                $temp = [];
                $refer = Refer::where('refer_id', $tempUserId)->first();
                $user  = User::find($tempUserId);
                if($user) {
                    $temp['created_at'] = $refer->created_at->format('Y-m-d H:i:s');
                    $temp['asset']      = '';
                    $temp['coin_amount']      = '';
                    
                    $temp['amount']   = 0;
                    $temp['user_id']    = $refer->refer_id; //refered user
                    $temp['referer']    = $refer->email; //refered user
                    
                    $temp['currency'] = "";
                    $temp['email']   =   $user->email;
                    $temp['address'] = $user->address;
                    $temp['referer_id'] = $user->id;
                    
                    $temp['reward']  = 0;
                    $refers_list[] = $temp;
                }
            }
        return view("admin.affiliation", compact('totalAffiliation', 'userList'))->with('active', 'affiliation')->with('transaction_list', $refers_list);
    }
    
    public function affiliationUser(Request $request) {
        $affiliationUsers = Refer::all();
        return view('admin.affiliationUser', compact('affiliationUsers'))->with('active', 'affiliationUser');
    }

    public function historyRecord(Request $request) {
        $usersPerDay = User::select(DB::raw('count(id) as `number_of_users`'),DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') new_date"))
                    // ->whereRaw('DATE(created_at) >= DATE_SUB(CURDATE(), INTERVAL 100 DAY)')
                    ->whereRaw('DATE(created_at) >= DATE("2021-01-01 00:00:00")')
                    ->groupBy('new_date')->orderBy('new_date', 'desc')->get();
        // dd($usersPerDay->pluck('number_of_users')->toArray() , $usersPerDay->pluck('number_of_users', 'new_date'));

        $allUsers = User::all()->count();
        
        return view('admin.historyRecord', compact('usersPerDay', 'allUsers'))->with('active', 'historyRecord');
    }

    public function affiliationManage(Request $request) {
        $refers = Refer::all();
        $token = $request->token;
        $userList = User::all();
        
        return view("admin.affiliationManage", compact('refers', 'userList'))->with('active', 'affiliationManage');
    }

    public function affiliationAdd(Request $request) {
        $validated = Validator::make($request->all(), [
            'user' => ['required', 'min:1'],
            'user_refered' => ['required']
        ]);

        if($request->user == $request->user_refered) {
            return back()->with('destroy', 'Same user not allowed!');
        }
        
        $refer = Refer::where('user_id', $request->user)->where('refer_id', $request->user_refered)->first();
        if($refer) {
            return back()->with('destroy', 'Same pair is exist!');
        }else {
            $new_refer = new Refer();
            $new_refer->user_id = $request->user;
            $new_refer->refer_id = $request->user_refered;
            $new_refer->save();
        }

        return back()->with('success', 'Successfully added');
    }

    public function referDestroy(Request $request, $id) {
        $refer = Refer::find($id);
        $refer->delete();
        return back();
    }

    public function referEdit(Request $request, $id) {
        $userList = User::all();
        $refer = Refer::find($id);
        return view('admin.affiliationEdit', compact('refer', 'userList'))->with('active', 'affiliationManage');
    }

    public function referUpdate(Request $request, $id) {
        $refer = Refer::find($id);
        $refer->user_id = $request->user;
        $refer->refer_id = $request->user_refered;
        $refer->save();
        return back();
    }

    public function historyRecordList(Request $request) {
        $date = $request->query('recordDate');
        $usersPerDay = User::where('created_at', 'like', '%'.$date.'%')->orderBy('created_at', 'desc')->get();
        
        $allUsers = User::all()->count();
        
        return view('admin.dailyHistoryRecord', compact('usersPerDay', 'allUsers'))->with('active', 'historyRecord');
    }

    public function bulkemail(Request $request)
    {
        return view('admin.bulkemail')->with('active', 'bulkemail');
    }

    public function cryptoHolders(Request $request) {
        // $ethereum = new \Ethereum('https://bsc-dataseed.binance.org/', 443);
        // dd(hexdec($ethereum->eth_getBalance('0xaA6B0Cc0f9f5A9B80ED690507E870c62e16194a0'))/pow(10, 18));
        $users_list = User::all();
        $totalHolders = User::count();
        return view('admin.cryptoHolders', compact('users_list', 'totalHolders'))->with('active', 'cryptoHolders');
    }

    public function cryptoHoldersEth(Request $request) {
        // $ethereum = new \Ethereum('https://bsc-dataseed.binance.org/', 443);
        // dd(hexdec($ethereum->eth_getBalance('0xaA6B0Cc0f9f5A9B80ED690507E870c62e16194a0'))/pow(10, 18));
        $users_list = User::all();
        $totalHolders = User::count();
        return view('admin.cryptoHoldersEth', compact('users_list', 'totalHolders'))->with('active', 'cryptoHoldersEth');
    }

    public function bulkemails() {
        return view('admin.bulkemail')->with('active', 'bulkemail');
    }
}
