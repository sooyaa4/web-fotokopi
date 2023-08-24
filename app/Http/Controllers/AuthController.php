<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Suppliers;
use App\Models\Transaksi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function dashboard()  {
        $produk = Produk::count();
        $supplier = Suppliers::count();
        $transaksi = Transaksi::count();
        return view('pages.dashboard', compact('produk', 'supplier', 'transaksi'));
    }

    public function login()  {

        if (Auth::check()) {
            return redirect()->intended('dashboard');
        }else{
            return view('pages.login');
        }
    }

    public function authenticate(Request $request): RedirectResponse
    {
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);
    
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->intended('dashboard');
            }
     
            return back()->with('danger', 'Email atau password salah!');
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
            return back()->with('danger', $th->getMessage());
        }
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
 
        $request->session()->invalidate();
 
        $request->session()->regenerateToken();
 
        return redirect('/');
    }
}
