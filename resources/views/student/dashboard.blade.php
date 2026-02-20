<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Student Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <div class="w-64 bg-indigo-800 text-white p-5 flex flex-col">
        <h2 class="text-center text-xl mb-8 border-b border-indigo-700 pb-4">📚 Library Portal</h2>
        <div class="mb-6">
            <p class="text-sm text-indigo-300">Welcome,</p>
            <p class="text-lg font-semibold">{{ Auth::user()->name }}</p>
        </div>
        <div class="menu-item p-3 mb-2 rounded hover:bg-indigo-700 cursor-pointer bg-indigo-700" onclick="showSection('bookList')">📖 Browse Books</div>
        <form action="{{ route('logout') }}" method="POST" class="mt-auto">
            @csrf
            <button type="submit" class="w-full p-3 bg-red-600 rounded hover:bg-red-700">🚪 Logout</button>
        </form>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-8 overflow-y-auto">

        <!-- Book List Section -->
        <div id="bookList" class="section">
            <div class="mb-6">
                <h1 class="text-3xl font-bold mb-4">Library Books</h1>
                <input type="text" id="searchInput" placeholder="Search books by title, author, or publisher..." 
                    class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <div id="booksGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Books will be loaded here -->
            </div>
        </div>

        <!-- Book Details Modal -->
        <div id="bookModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
            <div class="bg-white rounded-lg shadow-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <h2 id="modalTitle" class="text-2xl font-bold text-gray-800"></h2>
                        <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Book ID</p>
                                <p id="modalBookId" class="font-semibold"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Status</p>
                                <p id="modalStatus"></p>
                            </div>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-500">Author</p>
                            <p id="modalAuthor" class="font-semibold"></p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-500">Publisher</p>
                            <p id="modalPublisher" class="font-semibold"></p>
                        </div>

                        <div class="border-t pt-4">
                            <h3 class="text-lg font-semibold mb-3">Circulation History</h3>
                            <div id="circulationHistory" class="space-y-3">
                                <!-- Circulation records will be loaded here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
let allBooks = [];

function showSection(id){
    document.querySelectorAll('.section').forEach(s=>s.classList.add('hidden'));
    document.getElementById(id).classList.remove('hidden');
    if(id==='bookList') loadBooks();
}

function loadBooks(){
    fetch('/student/books')
        .then(r=>r.json())
        .then(books=>{
            allBooks = books;
            displayBooks(books);
        });
}

function displayBooks(books){
    const grid = document.getElementById('booksGrid');
    if(books.length === 0){
        grid.innerHTML = '<div class="col-span-full text-center text-gray-500 py-10">No books found</div>';
        return;
    }
    
    let html = '';
    books.forEach(book=>{
        const statusClass = book.status === 'Available' 
            ? 'bg-green-100 text-green-800' 
            : 'bg-red-100 text-red-800';
        
        html += `
            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow cursor-pointer overflow-hidden"
                onclick="showBookDetails(${book.id})">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="text-lg font-bold text-gray-800 line-clamp-2">${book.title}</h3>
                        <span class="${statusClass} px-2 py-1 rounded text-xs font-semibold">${book.status}</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-2">📝 ${book.author}</p>
                    <p class="text-sm text-gray-500 mb-3">🏢 ${book.publisher}</p>
                    <p class="text-xs text-gray-400">ID: ${book.book_id}</p>
                </div>
                <div class="bg-indigo-50 px-6 py-3 text-sm text-indigo-700 font-medium">
                    Click to view details →
                </div>
            </div>
        `;
    });
    grid.innerHTML = html;
}

document.getElementById('searchInput').addEventListener('input', function(e){
    const query = e.target.value.toLowerCase();
    const filtered = allBooks.filter(book=>
        book.title.toLowerCase().includes(query) ||
        book.author.toLowerCase().includes(query) ||
        book.publisher.toLowerCase().includes(query) ||
        book.book_id.toLowerCase().includes(query)
    );
    displayBooks(filtered);
});

function showBookDetails(bookId){
    fetch(`/student/books/${bookId}`)
        .then(r=>r.json())
        .then(book=>{
            document.getElementById('modalTitle').innerText = book.title;
            document.getElementById('modalBookId').innerText = book.book_id;
            document.getElementById('modalAuthor').innerText = book.author;
            document.getElementById('modalPublisher').innerText = book.publisher;
            
            const statusClass = book.status === 'Available' 
                ? 'bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold' 
                : 'bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold';
            document.getElementById('modalStatus').innerHTML = `<span class="${statusClass}">${book.status}</span>`;
            
            // Display circulation history
            const historyDiv = document.getElementById('circulationHistory');
            if(book.issues && book.issues.length > 0){
                let historyHtml = '<div class="space-y-3">';
                book.issues.forEach(issue=>{
                    const statusBadge = issue.status === 'issued' 
                        ? '<span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">Currently Issued</span>'
                        : '<span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs">Returned</span>';
                    
                    historyHtml += `
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <p class="font-semibold text-gray-800">${issue.user ? issue.user.name : 'Unknown'}</p>
                                    <p class="text-sm text-gray-600">${issue.user ? issue.user.email : ''}</p>
                                </div>
                                ${statusBadge}
                            </div>
                            <div class="grid grid-cols-3 gap-2 text-sm mt-3">
                                <div>
                                    <p class="text-gray-500">Issue Date</p>
                                    <p class="font-medium">${formatDate(issue.issue_date)}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Due Date</p>
                                    <p class="font-medium">${formatDate(issue.due_date)}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Return Date</p>
                                    <p class="font-medium">${issue.return_date ? formatDate(issue.return_date) : 'Not returned'}</p>
                                </div>
                            </div>
                        </div>
                    `;
                });
                historyHtml += '</div>';
                historyDiv.innerHTML = historyHtml;
            } else {
                historyDiv.innerHTML = '<p class="text-gray-500 text-center py-4">No circulation history available</p>';
            }
            
            document.getElementById('bookModal').classList.remove('hidden');
        });
}

function closeModal(){
    document.getElementById('bookModal').classList.add('hidden');
}

function formatDate(dateString){
    if(!dateString) return 'N/A';
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
}

// Close modal on outside click
document.getElementById('bookModal').addEventListener('click', function(e){
    if(e.target === this){
        closeModal();
    }
});

loadBooks();
</script>

</body>
</html>
