<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\BookIssue;
use App\Models\User;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            ['book_id' => 'BK001', 'title' => 'Introduction to Algorithms', 'author' => 'Thomas H. Cormen', 'publisher' => 'MIT Press', 'status' => 'Available'],
            ['book_id' => 'BK002', 'title' => 'Clean Code', 'author' => 'Robert C. Martin', 'publisher' => 'Prentice Hall', 'status' => 'Available'],
            ['book_id' => 'BK003', 'title' => 'Design Patterns', 'author' => 'Gang of Four', 'publisher' => 'Addison-Wesley', 'status' => 'Available'],
            ['book_id' => 'BK004', 'title' => 'The Pragmatic Programmer', 'author' => 'Andrew Hunt', 'publisher' => 'Addison-Wesley', 'status' => 'Issued'],
            ['book_id' => 'BK005', 'title' => 'Head First Java', 'author' => 'Kathy Sierra', 'publisher' => 'O\'Reilly Media', 'status' => 'Available'],
        ];

        foreach ($books as $bookData) {
            $book = Book::create($bookData);
            
            // Add some circulation history
            if ($bookData['status'] === 'Issued') {
                $student = User::where('role', 'student')->first();
                if ($student) {
                    BookIssue::create([
                        'book_id' => $book->id,
                        'user_id' => $student->id,
                        'issue_date' => now()->subDays(5),
                        'due_date' => now()->addDays(9),
                        'status' => 'issued'
                    ]);
                }
            }
        }
    }
}
