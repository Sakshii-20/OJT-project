<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Library Management System</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-white to-purple-50 min-h-screen flex items-center justify-center p-4">

    <!-- Login Card -->
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-100">
            
            <!-- Header -->
            <div class="bg-white p-6 text-center border-b border-slate-100">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fa-solid fa-book-open text-3xl text-blue-600"></i>
                </div>
                <h2 class="text-2xl font-bold text-slate-800">Welcome Back</h2>
                <p class="text-slate-500 text-sm mt-1">Login to your Library Account</p>
            </div>

            <!-- Login Form -->
            <div class="p-6">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email / ID Field -->
                    <div class="mb-4">
                        <label class="block text-slate-700 text-sm font-semibold mb-2">
                            <i class="fa-solid fa-envelope mr-1 text-blue-500"></i> Email / Student ID
                        </label>
                        <input 
                            type="text" 
                            name="email" 
                            required 
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-blue-500 focus:outline-none transition bg-slate-50 text-sm"
                            placeholder="Enter your email or ID"
                        >
                    </div>

                    <!-- Password Field -->
                    <div class="mb-4">
                        <label class="block text-slate-700 text-sm font-semibold mb-2">
                            <i class="fa-solid fa-lock mr-1 text-blue-500"></i> Password
                        </label>
                        <input 
                            type="password" 
                            name="password" 
                            required 
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-blue-500 focus:outline-none transition bg-slate-50 text-sm"
                            placeholder="Enter your password"
                        >
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex justify-between items-center mb-5">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="remember" class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                            <span class="ml-2 text-xs text-slate-500">Remember me</span>
                        </label>
                        <a href="#" class="text-xs text-blue-600 hover:text-blue-800 font-medium">Forgot Password?</a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full py-2.5 bg-blue-600 text-white rounded-lg font-semibold text-sm hover:bg-blue-700 transition shadow-md">
                        <i class="fa-solid fa-right-to-bracket mr-1"></i> Login
                    </button>
                </form>

                <!-- Register Link with Options -->
                <div class="mt-4 text-center">
                    <p class="text-slate-500 text-sm">Don't have an account? 
                        <button onclick="toggleRegisterModal()" class="text-blue-600 font-semibold hover:underline">
                            Register Here
                        </button>
                    </p>
                </div>
            </div>

            <!-- Back to Home -->
            <div class="bg-slate-50 px-6 py-3 text-center border-t border-slate-100">
                <a href="/" class="text-slate-500 hover:text-blue-600 transition text-sm flex items-center justify-center gap-1">
                    <i class="fa-solid fa-arrow-left text-xs"></i> Back to Home
                </a>
            </div>

        </div>
    </div>

    <!-- Registration Options Modal -->
    <div id="registerModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden">
            
            <!-- Modal Header -->
            <div class="bg-blue-600 p-4 text-center">
                <h3 class="text-white font-bold text-lg">Choose Registration Type</h3>
                <p class="text-blue-100 text-xs">Select your role to continue</p>
            </div>

            <!-- Modal Options -->
            <div class="p-4 space-y-3">
                
                <!-- Student Option -->
                <a href="{{ route('auth.studentregistration') }}" 
                   class="flex items-center p-4 border-2 border-green-200 rounded-xl hover:border-green-500 hover:bg-green-50 transition group">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4 group-hover:scale-110 transition">
                        <i class="fa-solid fa-graduation-cap text-xl text-green-600"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800">Student</h4>
                        <p class="text-xs text-slate-500">Register as a student member</p>
                    </div>
                    <i class="fa-solid fa-chevron-right ml-auto text-slate-400 group-hover:text-green-500"></i>
                </a>

                <!-- Admin Option -->
                <a href="{{ route('auth.adminregistration') }}" 
                   class="flex items-center p-4 border-2 border-purple-200 rounded-xl hover:border-purple-500 hover:bg-purple-50 transition group">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mr-4 group-hover:scale-110 transition">
                        <i class="fa-solid fa-user-shield text-xl text-purple-600"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800">Admin</h4>
                        <p class="text-xs text-slate-500">Register as an administrator</p>
                    </div>
                    <i class="fa-solid fa-chevron-right ml-auto text-slate-400 group-hover:text-purple-500"></i>
                </a>
            </div>

            <!-- Cancel Button -->
            <div class="bg-slate-50 p-3 text-center border-t border-slate-100">
                <button onclick="toggleRegisterModal()" class="text-slate-500 hover:text-slate-700 text-sm">
                    <i class="fa-solid fa-times mr-1"></i> Cancel
                </button>
            </div>

        </div>
    </div>

    <!-- JavaScript for Modal -->
    <script>
        function toggleRegisterModal() {
            const modal = document.getElementById('registerModal');
            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            } else {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }

        // Close modal when clicking outside
        document.getElementById('registerModal').addEventListener('click', function(e) {
            if (e.target === this) {
                toggleRegisterModal();
            }
        });
    </script>

</body>
</html>