namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
     return response()->json(Book::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'bookId' => 'required|unique:books,book_id',
            'bookTitle' => 'required',
            'bookAuthor' => 'required',
            'bookPublisher' => 'required',
            'bookAvailability' => 'required|in:Available,Issued'
        ]);

        $book = Book::create([
            'book_id' => $request->bookId,
            'title' => $request->bookTitle,
            'author' => $request->bookAuthor,
            'publisher' => $request->bookPublisher,
            'status' => $request->bookAvailability
        ]);

        return response()->json(['message'=>'Book added successfully','book'=>$book]);
    }

    public function destroy($id)
    {
        Book::destroy($id);
        return response()->json(['message'=>'Book deleted']);
    }
}
