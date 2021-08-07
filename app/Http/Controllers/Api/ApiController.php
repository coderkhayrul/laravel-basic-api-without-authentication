<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    // CREATE API - POST
    public function createEmployee(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required',
            'email' => 'required | email | unique:employees',
            'phone_no' => 'required',
            'gender' => 'required',
            'age' => 'required',
        ]);

        // Create Data
        $employees = new Employee();
        $employees->name = $request->name;
        $employees->email = $request->email;
        $employees->phone_no = $request->phone_no;
        $employees->gender = $request->gender;
        $employees->age = $request->age;
        $employees->save();

        // Send Response
        return response()->json([
            'status' => '1',
            'message' => 'Employee Created Sussessfully'
        ]);
    }

    // LIST API - GET
    public function listEmployee()
    {
        $employees = Employee::get();
        return response()->json([
            'status' => '1',
            'message' => 'Employee List',
            'data' => $employees
        ], 200);
    }

    // SINGLE DETAIL API - GET
    public function getSingleEmployee($id)
    {
        if (Employee::where('id', $id)->exists()) {
            $employee_detail = Employee::where('id', $id)->first();
            return response()->json([
                'status' => '1',
                'message' => 'Employee Found',
                'data' => $employee_detail
            ], 200);
        } else {
            return response()->json([
                'status' => '0',
                'message' => 'Employee Not Found',
            ], 404);
        }
    }

    // UPDATE API - PUT
    public function updateEmployee(Request $request, $id)
    {
        if (Employee::where('id', $id)->exists()) {
            $employee = Employee::find($id);
            $employee->name = !empty($request->name) ? $request->name : $employee->name;
            $employee->email = !empty($request->email) ? $request->email : $employee->email;
            $employee->phone_no = !empty($request->phone_no) ? $request->phone_no : $employee->phone_no;
            $employee->gender = !empty($request->gender) ? $request->gender : $employee->gender;
            $employee->age = !empty($request->age) ? $request->age : $employee->age;
            $employee->update();

            return response()->json([
                'status' => '1',
                'message' => 'Employee Update Successfully',
            ], 200);
        } else {
            return response()->json([
                'status' => '0',
                'message' => 'Employee Not Found',
            ], 404);
        }
    }

    // DELETE API - DELETE
    public function deleteEmployee($id)
    {
        if (Employee::where('id', $id)->exists()) {
            $employee = Employee::find($id);
            $employee->delete();

            return response()->json([
                'status' => '1',
                'message' => 'Employee Delete Successfully',
            ], 200);
        } else {
            return response()->json([
                'status' => '0',
                'message' => 'Employee Not Found',
            ], 404);
        }
    }
}
