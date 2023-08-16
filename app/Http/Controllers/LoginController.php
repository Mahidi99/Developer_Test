<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $userCredentials = [
            '001' => 'bentram37',
            '002' => 'blackroad19',
            '003' => 'murkypaste20',
        ];
        
        $user_id = $request->input('user_id');
        $password = $request->input('password');
        
        if (isset($userCredentials[$user_id]) && $userCredentials[$user_id] === $password) {
            Auth::loginUsingId($user_id);
            return redirect()->back()->withErrors(['login_error' => 'Successfully Login.']);
            // return redirect()->route('add_customer_details.store');
        } else {
            return redirect()->back()->withErrors(['login_error' => 'Invalid login credentials.']);
        }
    }
}


