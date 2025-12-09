<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WakasekProfileController extends Controller
{
    public function index()
    {
        $wakasek = Auth::user();

        if (!$wakasek) {
            return redirect()->route('login')->with('error', 'Login dulu ya.');
        }

        return view('wakasek.profile', compact('wakasek'));
    }
}
