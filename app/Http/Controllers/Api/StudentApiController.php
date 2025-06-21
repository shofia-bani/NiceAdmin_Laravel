<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class StudentApiController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return response()->json($students);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'student_id_number' => 'required|string|unique:students,student_id_number|max:255',
                'major' => 'nullable|string|max:255',
                'email' => 'required|email|unique:students,email|max:255', // <-- TAMBAHKAN INI
                'phone' => 'nullable|string|max:20', // <-- TAMBAHKAN INI
            ]);

            $student = Student::create($validatedData);
            return response()->json($student, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred.', 'error' => $e->getMessage()], 500);
        }
    }

    public function show(Student $student)
    {
        return response()->json($student);
    }

    public function update(Request $request, Student $student)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'student_id_number' => 'required|string|unique:students,student_id_number,' . $student->id . '|max:255',
                'major' => 'nullable|string|max:255',
                'email' => 'required|email|unique:students,email,' . $student->id . '|max:255', // <-- TAMBAHKAN INI
                'phone' => 'nullable|string|max:20', // <-- TAMBAHKAN INI
            ]);

            $student->update($validatedData);
            return response()->json($student);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred.', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return response()->json(null, 204);
    }
}