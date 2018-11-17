<?php

namespace App\Http\Controllers;

use App\Country;
use App\Employee;

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

    public function statistic() {
        $employee_count = Employee::count();
        $employee_avg_age = Employee::avg('age') + 0;

        return view('statistic', compact('employee_count', 'employee_avg_age'));
    }
}
