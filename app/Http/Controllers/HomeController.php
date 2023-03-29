<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $title = 'Dashboard';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title = $this->title;

        return view('home', compact('title'));
    }
}
