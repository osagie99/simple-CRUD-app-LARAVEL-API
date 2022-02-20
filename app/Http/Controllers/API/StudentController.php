<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Validation\Validator;

class StudentController extends Controller
{
    public function index () {
        $students = Student::all();
        return response()->json([
            'status' => 200,
            'students' => $students
        ]);
    }
    public function store(Request $request) {
       $validate = FacadesValidator::make($request->all(), [ 
           'name' => 'required|max:191',
            'email' => 'required|email|max:191',
            'course' => 'required|max:191',
            'phone' => 'required|max:10|max:10|',
       ]);
       $errors = $validate->errors();

        if($validate->fails()){
            return response()->json([
            'validate_err' => $errors,
        ]);
        } else {
            $student = new Student;
            $student->name = $request->input('name');
            $student->course = $request->input('course');
            $student->phone = $request->input('phone');
            $student->email = $request->input('email');
    
            $student->save();
    
            return response()->json([
                'status' => 200,
                'message' => 'Student Created Succesfully'
            ]);
        }

    }
    public function edit($id) {
        $student = Student::find($id);
        if($student) {
            return response()->json([
                "status" => 200,
                "student" => $student
            ]);
        } 
        else {
            return response()->json([
                "status" => 404,
                "message" => "No student with ID found"
            ]);
        }
    }

    public function update(Request $request, $id) {
        $student = Student::find($id);
        $student->name = $request->input('name');
        $student->course = $request->input('course');
        $student->phone = $request->input('phone');
        $student->email = $request->input('email');
        $student->update();

        return response()->json([
            'status' => 200,
            'message' => 'Student Updated Succesfully'
        ]);
    }

    public function destroy($id) {
        $student = Student::find($id);
        $student->delete();
        return response()->json([
            'status' =>  200,
            'message' => 'Student Deleted Succesfully'
        ]);
    }
}
