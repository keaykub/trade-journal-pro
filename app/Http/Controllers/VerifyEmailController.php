<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    public function __invoke(Request $request, $id, $hash)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect('/login')->with('error', 'ไม่พบผู้ใช้');
        }
        
        if ($user->hasVerifiedEmail()) {
            return redirect('/dashboard')->with('message', 'อีเมลได้รับการยืนยันแล้ว');
        }

        // ยืนยันอีเมล
        $user->email_verified_at = now();
        $user->save();

        // Login user ถ้ายังไม่ได้ login
        if (!auth()->check()) {
            auth()->login($user);
        }

        return redirect('/dashboard')->with('message', 'ยืนยันอีเมลสำเร็จ!');
    }
}
