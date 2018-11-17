<?php

namespace App\Http\Controllers;

use App\Country;
use App\Employee;
use Illuminate\Http\Request;
use Validator;

class EmployeeController extends Controller
{
    public function datatable(Request $request) {
        $data = Employee::from('employees as a')
                ->join('countries as b', 'a.country_id', '=', 'b.id')
                ->select('a.id', \DB::raw("CONCAT(first_name, ' ', last_name) as name"), 'b.name as country', 'a.age');

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

        // try to move files if avatar not empty
        if (isset($data["avatar"]) && $data["avatar"] != "") {
            $image_path = public_path("images/employees");

            if (!is_dir($image_path)) {
                mkdir($image_path, 0774, true);
            }
    
            $image = $data["avatar"];
            $name = sha1(date('YmdHis') . str_random(30));
            $save_name = $name . '.' . $image->getClientOriginalExtension();

            $image->move($image_path, $save_name);
    
            $data["avatar"] = $save_name;
        }

        Employee::create($data);
    }

    public function show(Employee $employee) {
        $employee["country"] = Country::find($employee->country_id)->name;
        return $employee;
    }
}
