<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Book;
use App\Models\BookIssue;

class StudentController extends Controller
{
    public function dashboard()
    {
        return view('student.dashboard');
    }

    public function getStudentsJson()
    {
        $students = User::where('role', 'student')
                        ->withCount(['bookIssues as books_issued' => function($query) {
                            $query->where('status', 'issued');
                        }])
                        ->select('id', 'name', 'email', 'class')
                        ->get()
                        ->map(function($student) {
                            return [
                                'student_id' => $student->id,
                                'name' => $student->name,
                                'email' => $student->email,
                                'class' => $student->class,
                                'books_issued' => $student->books_issued ?? 0
                            ];
                        });

        return response()->json($students);
    }

    public function getBooks()
    {
        $books = Book::with(['currentIssue.user', 'issues' => function($query) {
            $query->orderBy('created_at', 'desc');
        }])->get();
        return response()->json($books);
    }

    public function getBookDetails($id)
    {
        $book = Book::with(['issues.user' => function($query) {
            $query->select('id', 'name', 'email');
        }])->findOrFail($id);
        
        return response()->json($book);
    }
}
