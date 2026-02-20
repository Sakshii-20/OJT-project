<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <div class="w-64 bg-gray-800 text-white p-5 flex flex-col">
        <h2 class="text-center text-xl mb-8 border-b border-gray-700 pb-4">📚 Admin Panel</h2>
        <div class="menu-item p-3 mb-2 rounded hover:bg-gray-700 cursor-pointer bg-gray-700" onclick="showSection('dashboard', event)">📊 Dashboard</div>
        <div class="menu-item p-3 mb-2 rounded hover:bg-gray-700 cursor-pointer" onclick="showSection('bookList', event)">📖 Manage Books</div>
        <div class="menu-item p-3 mb-2 rounded hover:bg-gray-700 cursor-pointer" onclick="showSection('studentList', event)">👨‍🎓 View Students</div>
        <form action="{{ route('logout') }}" method="POST" class="mt-auto">
            @csrf
            <button type="submit" class="w-full p-3 bg-red-600 rounded hover:bg-red-700">🚪 Logout</button>
        </form>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-8 overflow-y-auto">

        <!-- Dashboard Stats -->
        <div id="dashboard" class="section">
            <h1 class="text-2xl mb-6">Dashboard Overview</h1>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                <div class="bg-white p-5 rounded shadow text-center">
                    <h3 class="text-gray-500 text-sm mb-2">Total Books</h3>
                    <div id="totalBooks" class="text-3xl font-bold text-gray-800">0</div>
                </div>
                <div class="bg-white p-5 rounded shadow text-center">
                    <h3 class="text-gray-500 text-sm mb-2">Available Books</h3>
                    <div id="availableBooks" class="text-3xl font-bold text-gray-800">0</div>
                </div>
                <div class="bg-white p-5 rounded shadow text-center">
                    <h3 class="text-gray-500 text-sm mb-2">Issued Books</h3>
                    <div id="issuedBooks" class="text-3xl font-bold text-gray-800">0</div>
                </div>
                <div class="bg-white p-5 rounded shadow text-center">
                    <h3 class="text-gray-500 text-sm mb-2">Total Students</h3>
                    <div id="totalStudents" class="text-3xl font-bold text-gray-800">0</div>
                </div>
            </div>
        </div>

        <!-- Book List & Management -->
        <div id="bookList" class="section hidden">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl">Manage Books</h1>
                <button onclick="showAddBookForm()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">➕ Add New Book</button>
            </div>

            <!-- Add/Edit Book Form -->
            <div id="bookFormContainer" class="hidden bg-white p-6 rounded shadow mb-6">
                <h2 class="text-xl mb-4" id="formTitle">Add New Book</h2>
                <form id="bookForm" class="grid grid-cols-2 gap-4">
                    <input type="hidden" id="bookEditId">
                    <input type="text" id="bookId" placeholder="Book ID" class="p-2 border rounded" required>
                    <input type="text" id="bookTitle" placeholder="Title" class="p-2 border rounded" required>
                    <input type="text" id="bookAuthor" placeholder="Author" class="p-2 border rounded" required>
                    <input type="text" id="bookPublisher" placeholder="Publisher" class="p-2 border rounded" required>
                    <select id="bookStatus" class="p-2 border rounded">
                        <option value="Available">Available</option>
                        <option value="Issued">Issued</option>
                    </select>
                    <div class="col-span-2 flex gap-2">
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Save Book</button>
                        <button type="button" onclick="hideBookForm()" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Cancel</button>
                    </div>
                </form>
            </div>

            <!-- Books Table -->
            <div class="bg-white rounded shadow overflow-hidden">
                <table class="w-full">
                    <thead>
                        <tr class="bg-blue-600 text-white">
                            <th class="p-3 text-left">Book ID</th>
                            <th class="p-3 text-left">Title</th>
                            <th class="p-3 text-left">Author</th>
                            <th class="p-3 text-left">Publisher</th>
                            <th class="p-3 text-left">Status</th>
                            <th class="p-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="bookTableBody"></tbody>
                </table>
            </div>
        </div>

        <!-- Students List -->
        <div id="studentList" class="section hidden">
            <h1 class="text-2xl mb-6">Students</h1>
            <div class="bg-white rounded shadow overflow-hidden">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-700 text-white">
                            <th class="p-3 text-left">ID</th>
                            <th class="p-3 text-left">Name</th>
                            <th class="p-3 text-left">Email</th>
                            <th class="p-3 text-left">Class</th>
                            <th class="p-3 text-left">Books Issued</th>
                        </tr>
                    </thead>
                    <tbody id="studentTableBody"></tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

function showSection(id, e){
    document.querySelectorAll('.section').forEach(s=>s.classList.add('hidden'));
    document.getElementById(id).classList.remove('hidden');
    document.querySelectorAll('.menu-item').forEach(m=>m.classList.remove('bg-gray-700'));
    if(e) e.target.classList.add('bg-gray-700');

    if(id==='dashboard') updateDashboard();
    if(id==='bookList') { hideBookForm(); displayBooks(); }
    if(id==='studentList') displayStudents();
}

function updateDashboard(){
    Promise.all([
        fetch('/admin/books').then(r=>r.json()),
        fetch('/students').then(r=>r.json())
    ]).then(([books, students])=>{
        document.getElementById('totalBooks').innerText = books.length;
        document.getElementById('availableBooks').innerText = books.filter(b=>b.status==='Available').length;
        document.getElementById('issuedBooks').innerText = books.filter(b=>b.status==='Issued').length;
        document.getElementById('totalStudents').innerText = students.length;
    });
}

function showAddBookForm(){
    document.getElementById('formTitle').innerText = 'Add New Book';
    document.getElementById('bookForm').reset();
    document.getElementById('bookEditId').value = '';
    document.getElementById('bookId').disabled = false;
    document.getElementById('bookFormContainer').classList.remove('hidden');
}

function hideBookForm(){
    document.getElementById('bookFormContainer').classList.add('hidden');
}

function editBook(book){
    document.getElementById('formTitle').innerText = 'Edit Book';
    document.getElementById('bookEditId').value = book.id;
    document.getElementById('bookId').value = book.book_id;
    document.getElementById('bookId').disabled = true;
    document.getElementById('bookTitle').value = book.title;
    document.getElementById('bookAuthor').value = book.author;
    document.getElementById('bookPublisher').value = book.publisher;
    document.getElementById('bookStatus').value = book.status;
    document.getElementById('bookFormContainer').classList.remove('hidden');
    document.getElementById('bookList').scrollIntoView({behavior: 'smooth'});
}

document.getElementById('bookForm').addEventListener('submit', function(e){
    e.preventDefault();
    const editId = document.getElementById('bookEditId').value;
    const data = {
        book_id: document.getElementById('bookId').value,
        title: document.getElementById('bookTitle').value,
        author: document.getElementById('bookAuthor').value,
        publisher: document.getElementById('bookPublisher').value,
        status: document.getElementById('bookStatus').value
    };

    const url = editId ? `/admin/books/${editId}` : '/admin/books';
    const method = editId ? 'PUT' : 'POST';

    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify(data)
    }).then(r=>r.json()).then(resp=>{
        alert(resp.message);
        hideBookForm();
        updateDashboard();
        displayBooks();
    }).catch(err=>{
        alert('Error: ' + err.message);
    });
});

function displayBooks(){
    fetch('/admin/books').then(r=>r.json()).then(books=>{
        let html='';
        books.forEach(b=>{
            const badge = b.status==='Available'?'bg-green-100 text-green-800 px-2 py-1 rounded':'bg-red-100 text-red-800 px-2 py-1 rounded';
            html+=`<tr class="border-b hover:bg-gray-50">
                <td class="p-3">${b.book_id}</td>
                <td class="p-3">${b.title}</td>
                <td class="p-3">${b.author}</td>
                <td class="p-3">${b.publisher}</td>
                <td class="p-3"><span class="${badge}">${b.status}</span></td>
                <td class="p-3">
                    <button onclick='editBook(${JSON.stringify(b)})' class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 mr-2">Edit</button>
                    <button onclick="deleteBook(${b.id})" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Delete</button>
                </td>
            </tr>`;
        });
        document.getElementById('bookTableBody').innerHTML=html || '<tr><td colspan="6" class="p-3 text-center text-gray-500">No books found</td></tr>';
    });
}

function deleteBook(id){
    if(confirm('Are you sure you want to delete this book?')){
        fetch(`/admin/books/${id}`, {
            method: 'DELETE',
            headers: {'X-CSRF-TOKEN': csrfToken}
        }).then(r=>r.json()).then(resp=>{
            alert(resp.message);
            updateDashboard();
            displayBooks();
        });
    }
}

function displayStudents(){
    fetch('/students')
        .then(r=>{
            if(!r.ok) {
                throw new Error('HTTP error! status: ' + r.status);
            }
            return r.json();
        })
        .then(students=>{
            console.log('Students data:', students);
            let html='';
            students.forEach(s=>{
                html+=`<tr class="border-b hover:bg-gray-50">
                    <td class="p-3">${s.student_id}</td>
                    <td class="p-3">${s.name}</td>
                    <td class="p-3">${s.email}</td>
                    <td class="p-3">${s.class || 'N/A'}</td>
                    <td class="p-3">${s.books_issued || 0}</td>
                </tr>`;
            });
            document.getElementById('studentTableBody').innerHTML=html || '<tr><td colspan="5" class="p-3 text-center text-gray-500">No students found</td></tr>';
        })
        .catch(err=>{
            console.error('Error fetching students:', err);
            document.getElementById('studentTableBody').innerHTML='<tr><td colspan="5" class="p-3 text-center text-red-500">Error loading students: ' + err.message + '</td></tr>';
        });
}

updateDashboard();
</script>

</body>
</html>
