<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use Validator;

class EmployeeController extends Controller
{
    public function datatable(Request $request) {
        $data = Employee::from('employees as a')
                ->join('countries as b', 'a.country_id', '=', 'b.id')
                ->select(\DB::raw("CONCAT(first_name, ' ', last_name) as name"), 'b.name as country', 'a.age');

        return datatable($data, $request);
    }

    public function store(Request $request) {
        $data = $request->all();

        $validator = Validator::make($data, [
            'first_name' => 'required',
            'last_name' => 'required',
            'age'       => 'required|numeric|min:17',
            'country_id'   => 'required|numeric',
        ]);
        
        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }

        Employee::create($data);
    }
}
