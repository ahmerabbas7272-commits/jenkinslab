<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        return view('students', [
            'students' => Student::latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:students,email'],
            'course' => ['required', 'string', 'max:100'],
        ]);

        Student::create($data);

        return redirect('/')
            ->with('success', 'Student saved successfully.');
    }
}
