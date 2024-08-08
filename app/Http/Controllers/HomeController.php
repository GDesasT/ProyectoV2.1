<?php

namespace App\Http\Controllers;

use App\Models\CarouselImage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function menu()
    {
        $images = CarouselImage::where('is_active', true)->get();
        return view('menu', compact('images'));
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
