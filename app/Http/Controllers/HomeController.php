<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function menu()
    {
        return view('menu');
    }
    
    public function feedback()
    {
        return view('feedback');
    }

    public function inventory(){
        return view('inventory');
    }

    public function pointofsale(){
        return view('PointOfSale');
    }
}
