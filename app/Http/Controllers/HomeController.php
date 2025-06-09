<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function pricing()
    {
        return view('pricing');
    }

    public function faq()
    {
        return view('faq');
    }

    public function about()
    {
        return view('about');
    }

    public function demo()
    {
        return view('demo');
    }

    public function dashboard()
    {
        return view('dashboard');
    }
}
