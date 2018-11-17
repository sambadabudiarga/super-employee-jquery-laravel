<?php

namespace App\Http\Controllers;

use App\Country;

use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = Country::lists('name', 'id');
        return view('home', compact('countries'));
    }
}
