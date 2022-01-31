<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
class SlamController extends Controller
{
    public function user(){
        $user = User::all()->toArray();
        dd($user);
    }
}
