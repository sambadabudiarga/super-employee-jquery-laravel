<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Employee;
use App\Http\Requests;

class EmployeeController extends Controller
{
    public function datatable(Request $request) {
        $data = Employee::from('employees as a')
                ->join('countries as b', 'a.country_id', '=', 'b.id')
                ->select(\DB::raw("CONCAT(first_name, ' ', last_name) as name"), 'b.name as country', 'a.age');

        return datatable($data, $request);
    }
}
