<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\BookIssue;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard'); 
    }

    public function getBooks()
    {
        $books = Book::with(['author', 'publisher', 'currentIssue.user'])->get();
        return response()->json($books);
    }

    public function storeBook(Request $request)
    {
        $request->validate([
            'book_id' => 'required|unique:books,book_id',
            'title' => 'required',
            'author' => 'required|string',
            'publisher' => 'required|string',
            'status' => 'required|in:Available,Issued'
        ]);

        // Create or get author
        $author = Author::firstOrCreate(['name' => $request->author]);
        
        // Create or get publisher
        $publisher = Publisher::firstOrCreate(['name' => $request->publisher]);

        // Create book with author_id and publisher_id
        $book = Book::create([
            'book_id' => $request->book_id,
            'title' => $request->title,
            'author_id' => $author->id,
            'publisher_id' => $publisher->id,
            'status' => $request->status
        ]);
        
        $book->load(['author', 'publisher']);
        return response()->json(['message' => 'Book added successfully', 'book' => $book]);
    }

    public function updateBook(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        
        $request->validate([
            'title' => 'required',
            'author' => 'required|string',
            'publisher' => 'required|string',
        ]);
        
        // Create or get author
        $author = Author::firstOrCreate(['name' => $request->author]);
        
        // Create or get publisher
        $publisher = Publisher::firstOrCreate(['name' => $request->publisher]);
        
        $book->update([
            'book_id' => $request->book_id,
            'title' => $request->title,
            'author_id' => $author->id,
            'publisher_id' => $publisher->id,
            'status' => $request->status
        ]);
        
        $book->load(['author', 'publisher']);
        return response()->json(['message' => 'Book updated successfully', 'book' => $book]);
    }

    public function deleteBook($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return response()->json(['message' => 'Book deleted successfully']);
    }
}
