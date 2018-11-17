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

    public function chart() {
        $data = [];

        $data["emp_ages"] = Employee::distinct()->orderBy('age')->lists('age', 'age')->toArray();
        $data["emp_countries"] = Country::orderBy('name')->lists('name', 'id')->toArray();

        $employee_ages = Employee::from('employees as a')
                        ->join('countries as b', 'a.country_id', '=', 'b.id')
                        ->selectRaw('b.name as country, a.age, COUNT(*) as data_count')
                        ->groupBy('b.name', 'a.age')
                        ->orderBy('b.name', 'asc')
                        ->orderBy('a.age', 'asc')
                        ->get()
                        ->toArray();

        foreach($employee_ages as $employee_age) {
            if (!isset($data["datasets"][$employee_age["country"]])) {
                $data["datasets"][$employee_age["country"]]['label'] = $employee_age["country"];
                $data["datasets"][$employee_age["country"]]['fill'] = false;
                $data["datasets"][$employee_age["country"]]['spanGaps'] = true;
                $the_color = "rgba(" . rand(0, 255) . ", " . rand(0, 255) . ", " . rand(0, 255) . ", 0.73)";
                $data["datasets"][$employee_age["country"]]['borderColor'] = $the_color;
                $data["datasets"][$employee_age["country"]]['pointBorderColor'] = $the_color;
                $data["datasets"][$employee_age["country"]]['pointBackgroundColor'] = $the_color;
                $data["datasets"][$employee_age["country"]]['pointHoverBackgroundColor'] = "#fff";
                $data["datasets"][$employee_age["country"]]['pointHoverBorderColor'] = $the_color;

                // $data["datasets"][$employee_age["country"]]['data'] = [];
                // $data["datasets"][$employee_age["country"]]['data']['labels'] = $data["emp_ages"];

                // for ($i = 0; $i < count($data["emp_ages"]); $i++) {
                //     $data["datasets"][$employee_age["country"]]['data'][$i] = null;
                // foreach($data["emp_ages"] as $emp_age) {
                //     $data["datasets"][$employee_age["country"]]['data']['y'] = 
                // }
            }

            // array_push($data["datasets"][$employee_age["country"]]['data'], [
            //     'x' => $employee_age["age"],
            //     'y' => $employee_age["data_count"],
            // ]);

            // $array_key = array_keys($data["emp_ages"], $employee_age["age"])[0];
            // $data["datasets"][$employee_age["country"]]['data'][$array_key] = $employee_age["data_count"];
            $data["datasets"][$employee_age["country"]]['data'][] = [
                'x' => $employee_age["age"],
                'y' => $employee_age["data_count"],
            ];
        }

        return ($data);
        // return json_encode($data);
    }

    public function rand_color() {
        return str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }
}
