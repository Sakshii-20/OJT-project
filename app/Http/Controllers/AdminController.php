<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BookIssue;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard'); 
    }

    public function getBooks()
    {
        $books = Book::with('currentIssue.user')->get();
        return response()->json($books);
    }

    public function storeBook(Request $request)
    {
        $request->validate([
            'book_id' => 'required|unique:books,book_id',
            'title' => 'required',
            'author' => 'required',
            'publisher' => 'required',
            'status' => 'required|in:Available,Issued'
        ]);

        $book = Book::create($request->all());
        return response()->json(['message' => 'Book added successfully', 'book' => $book]);
    }

    public function updateBook(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        $book->update($request->all());
        return response()->json(['message' => 'Book updated successfully', 'book' => $book]);
    }

    public function deleteBook($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return response()->json(['message' => 'Book deleted successfully']);
    }
}
