<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; }
        
        .gradient-text {
            background: linear-gradient(to right, #2563eb, #9333ea);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .blob {
            position: absolute;
            filter: blur(80px);
            z-index: -1;
            opacity: 0.5;
            animation: move 10s infinite alternate;
        }
        @keyframes move {
            from { transform: translate(0, 0); }
            to { transform: translate(20px, -20px); }
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen relative overflow-x-hidden flex flex-col">

    <!-- Background Decoration -->
    <div class="blob bg-blue-300 w-96 h-96 rounded-full top-0 left-0"></div>
    <div class="blob bg-purple-300 w-80 h-80 rounded-full bottom-0 right-0"></div>

    <!-- Navbar -->
    <nav class="w-full px-6 py-4 flex justify-between items-center bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-50">
        <div class="flex items-center gap-2">
            <i class="fa-solid fa-book-open text-3xl text-blue-600"></i>
            <span class="text-xl font-bold text-slate-800">LMS Portal</span>
        </div>
        <div>
            @guest
                <a href="/login" class="px-5 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition shadow-lg shadow-blue-500/30">
                    <i class="fa-solid fa-right-to-bracket mr-2"></i> Login
                </a>
            @else
                <div class="flex items-center gap-3">
                    <span class="text-slate-600 font-medium">Hi, {{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-semibold">Logout</button>
                    </form>
                </div>
            @endguest
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-10 flex-grow">
        
        <!-- Hero Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-6xl font-extrabold mb-4 text-slate-800 leading-tight">
                Welcome to the <span class="gradient-text">Future of Library</span>
            </h1>
            <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                Access thousands of books, track your issues, and manage your reading journey seamlessly.
            </p>
        </div>

        <!-- Video Section -->
        <div class="max-w-4xl mx-auto mb-16 relative group">
            <div class="absolute -inset-2 bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-1000"></div>
            <div class="relative rounded-2xl overflow-hidden shadow-2xl border-4 border-white bg-black">
                <video class="w-full h-auto object-cover max-h-[500px]" autoplay loop muted playsinline>
                    <source src="{{ asset('videos/home.mp4') }}" type="video/mp4">
                </video>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-12 max-w-4xl mx-auto">
            <div class="bg-white p-4 rounded-xl shadow-md text-center border-b-4 border-blue-500">
                <div class="text-2xl font-bold text-slate-800">5,000+</div>
                <div class="text-xs text-slate-500 uppercase tracking-wide">Books</div>
            </div>
            <div class="bg-white p-4 rounded-xl shadow-md text-center border-b-4 border-green-500">
                <div class="text-2xl font-bold text-slate-800">1,200+</div>
                <div class="text-xs text-slate-500 uppercase tracking-wide">Students</div>
            </div>
            <div class="bg-white p-4 rounded-xl shadow-md text-center border-b-4 border-purple-500">
                <div class="text-2xl font-bold text-slate-800">850+</div>
                <div class="text-xs text-slate-500 uppercase tracking-wide">Issues</div>
            </div>
            <div class="bg-white p-4 rounded-xl shadow-md text-center border-b-4 border-orange-500">
                <div class="text-2xl font-bold text-slate-800">24/7</div>
                <div class="text-xs text-slate-500 uppercase tracking-wide">Access</div>
            </div>
        </div>

        <!-- Role-Based Access Cards -->
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-slate-700">Select Your Portal</h2>
            <div class="w-20 h-1 bg-blue-600 mx-auto mt-2 rounded-full"></div>
        </div>

        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3 max-w-5xl mx-auto justify-center">
            
            @if(auth()->check())
                @if(auth()->user()->role == 'admin')
                    <!-- Admin Card -->
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:-translate-y-2 transition transform duration-300 border-t-8 border-blue-600 group">
                        <div class="h-32 bg-gradient-to-r from-blue-600 to-blue-800 flex items-center justify-center">
                            <i class="fa-solid fa-user-shield text-6xl text-white/90 group-hover:scale-110 transition"></i>
                        </div>
                        <div class="p-8 text-center">
                            <h3 class="text-2xl font-bold text-slate-800 mb-2">Admin Panel</h3>
                            <p class="text-slate-500 mb-6">Full control over library inventory, member management, and reports.</p>
                            <a href="/admin/dashboard" class="inline-block w-full py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition shadow-lg shadow-blue-500/30">
                                Go to Dashboard <i class="fa-solid fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                @elseif(auth()->user()->role == 'student')
                    <!-- Student Card -->
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:-translate-y-2 transition transform duration-300 border-t-8 border-green-500 group">
                        <div class="h-32 bg-gradient-to-r from-green-500 to-emerald-700 flex items-center justify-center">
                            <i class="fa-solid fa-graduation-cap text-6xl text-white/90 group-hover:scale-110 transition"></i>
                        </div>
                        <div class="p-8 text-center">
                            <h3 class="text-2xl font-bold text-slate-800 mb-2">Student Panel</h3>
                            <p class="text-slate-500 mb-6">Check issued books, due dates, and renew your books easily.</p>
                            <a href="/student/dashboard" class="inline-block w-full py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition shadow-lg shadow-green-500/30">
                                My Library <i class="fa-solid fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                @endif
            @else
                <!-- Guest / Login Card -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:-translate-y-2 transition transform duration-300 border-t-8 border-purple-500 group col-span-1 md:col-span-2 lg:col-span-3 max-w-md mx-auto w-full">
                    <div class="h-32 bg-gradient-to-r from-purple-600 to-indigo-800 flex items-center justify-center">
                        <i class="fa-solid fa-users-viewfinder text-6xl text-white/90 group-hover:scale-110 transition"></i>
                    </div>
                    <div class="p-8 text-center">
                        <h3 class="text-2xl font-bold text-slate-800 mb-2">Guest Access</h3>
                        <p class="text-slate-500 mb-6">Please login to access your personalized dashboard.</p>
                        <a href="/login" class="inline-block w-full py-3 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition shadow-lg shadow-purple-500/30">
                            Login Now <i class="fa-solid fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            @endif

        </div>

    </div>

    <!-- Footer -->
    <footer class="mt-auto py-6 text-center text-slate-400 text-sm bg-white/50 backdrop-blur">
        <p>&copy; {{ date('Y') }} Library Management System. All rights reserved.</p>
    </footer>

</body>
</html>