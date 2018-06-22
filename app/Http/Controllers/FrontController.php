<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class FrontController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth',['only' => 'principal']);
    }
    public function index()
    {
        return view('index');
    }
    public function principal()
    {
        return view('principal');
    }
    /*public function users()
    {
        return view('users');
    }
    public function log()
    {
        return view('log');
    }*/
    public function landing()
    {
        return view('landing3');
    }
    
}