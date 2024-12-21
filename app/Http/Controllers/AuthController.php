<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function showRegistrationForm(){
        return view('auth.register'); 
    }
    public function register(Request $request){
        $request->validate([
            'username' => 'required|string|max:20|unique:user,login',
            'email' => 'required|string|email|max:255|unique:user,email',
            'password' => 'required|string|min:8',
        ]);
    
        $role = Role::where('role_name', 'User')->first();
    
        if (!$role) {
            return back()->withErrors(['role' => 'Default role "User" not found']);
        }
    
        $user = User::create([
            'login' => $request->username,
            'email' => $request->email,
            'password_hash' => Hash::make($request->password),
            'role_id' => $role->role_id,
            'display_name' => $request->username
        ]);
    
        return redirect()->route('login')->with('success', 'Registration successful. Please login.');
    }
    
    public function showLoginForm(){
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string',
            'password' => 'required|string',
        ]);
    
        $user = User::where('login', $request->identifier)
                    ->orWhere('email', $request->identifier)
                    ->first();
    
        if (!$user) {
            return back()->withErrors(['identifier' => 'No user found with this identifier.']);
        }
    
        if (!Hash::check($request->password, $user->password_hash)) {
            return back()->withErrors(['password' => 'Invalid password']);
        }
    
        $remember = $request->has('remember') ? true : false;
    
        Auth::login($user, $remember);
    
        $cookieLogin = cookie('user_login', $user->login, 60*24*30);
        $cookieEmail = cookie('user_email', $user->email, 60*24*30);
    
        return redirect()->route('home')->with('success', 'Login successful')
                ->cookie($cookieLogin)
                ->cookie($cookieEmail);
    }
}