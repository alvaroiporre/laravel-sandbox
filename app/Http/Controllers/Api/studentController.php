<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;

class studentController extends Controller
{
    public function index() {
        $students = Student::all();
        if ( $students->isEmpty()) {
            return response()->json([
                'message' => 'There are not students',
                'status' => 404
            ], 200);
        }
        return response()->json($students);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:student',
            'phone' => 'required|digits:10'
            //'language' => 'required|in:English,Spanish,French'
        ]);
        if ( $validator->fails()) {
            $data = [
                'message' => 'Error validating data',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
        $student = Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone
        ]);
        if (!$student) {
            $data = [
                'message' => 'Error creating student',
                'status' => 400
            ];
            return response()->json($data, 500);
        }

        return response()->json([
            'student' => $student,
            'message' => 'Student created succesfully'
        ], 200);
    }

    public function show($id) {
        $student = Student::find($id);
        if (!$student) {
            $data = [
                'message' => 'Student did not exist',
                'status' => 404
            ];
            return  response()->json($data, 404);
        }
        $data = [
            'student' => $student,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function delete($id) {
        $student = Student::find($id);
        if (!$student) {
            $data = [
                'message' => 'Student did not exist',
                'status' => 404
            ];
            return  response()->json($data, 404);
        }
        $student->delete();
        $data = [
            'message' => 'Student deleted succesfully',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function update(Request $request, $id) {
        $student = Student::find($id);
        if (!$student) {
            $data = [
                'message' => 'Student did not exist',
                'status' => 404
            ];
            return  response()->json($data, 404);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:student',
            'phone' => 'required|digits:10'
        ]);
        if ( $validator->fails()) {
            $data = [
                'message' => 'Error validating data',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->save();

        $data = [
            'message' => 'Student up to date',
            'student' => $student,
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
