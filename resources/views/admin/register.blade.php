<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration - Library Management System</title>
    
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
<body class="bg-gradient-to-br from-purple-50 via-white to-indigo-50 min-h-screen flex items-center justify-center p-4">

    <!-- Registration Card -->
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-100">
            
            <!-- Header -->
            <div class="bg-white p-6 text-center border-b border-slate-100">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fa-solid fa-user-shield text-3xl text-purple-600"></i>
                </div>
                <h2 class="text-2xl font-bold text-slate-800">Admin Registration</h2>
                <p class="text-slate-500 text-sm mt-1">Create your admin account</p>
            </div>

            <!-- Registration Form -->
            <div class="p-6">
                <form method="POST" action="{{ route('admin.register.post') }}">
                    @csrf

                    <!-- Name Field -->
                    <div class="mb-3">
                        <label class="block text-slate-700 text-sm font-semibold mb-2">
                            <i class="fa-solid fa-user mr-1 text-purple-500"></i> Full Name
                        </label>
                        <input 
                            type="text" 
                            name="name" 
                            required 
                            class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:border-purple-500 focus:outline-none transition bg-slate-50 text-sm"
                            placeholder="Enter your full name"
                        >
                    </div>

                    <!-- Email Field -->
                    <div class="mb-3">
                        <label class="block text-slate-700 text-sm font-semibold mb-2">
                            <i class="fa-solid fa-envelope mr-1 text-purple-500"></i> Email Address
                        </label>
                        <input 
                            type="email" 
                            name="email" 
                            required 
                            class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:border-purple-500 focus:outline-none transition bg-slate-50 text-sm"
                            placeholder="Enter your email"
                        >
                    </div>

                    <!-- Phone Field -->
                    <div class="mb-3">
                        <label class="block text-slate-700 text-sm font-semibold mb-2">
                            <i class="fa-solid fa-phone mr-1 text-purple-500"></i> Phone Number
                        </label>
                        <input 
                            type="text" 
                            name="phone" 
                            required 
                            class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:border-purple-500 focus:outline-none transition bg-slate-50 text-sm"
                            placeholder="Enter phone number"
                        >
                    </div>

                    <!-- Address Field -->
                    <div class="mb-3">
                        <label class="block text-slate-700 text-sm font-semibold mb-2">
                            <i class="fa-solid fa-location-dot mr-1 text-purple-500"></i> Address
                        </label>
                        <textarea 
                            name="address" 
                            required 
                            rows="2"
                            class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:border-purple-500 focus:outline-none transition bg-slate-50 text-sm"
                            placeholder="Enter your address"
                        ></textarea>
                    </div>

                    <!-- Password Field -->
                    <div class="mb-3">
                        <label class="block text-slate-700 text-sm font-semibold mb-2">
                            <i class="fa-solid fa-lock mr-1 text-purple-500"></i> Password
                        </label>
                        <input 
                            type="password" 
                            name="password" 
                            required 
                            class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:border-purple-500 focus:outline-none transition bg-slate-50 text-sm"
                            placeholder="Create a password"
                        >
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="mb-4">
                        <label class="block text-slate-700 text-sm font-semibold mb-2">
                            <i class="fa-solid fa-lock mr-1 text-purple-500"></i> Confirm Password
                        </label>
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            required 
                            class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:border-purple-500 focus:outline-none transition bg-slate-50 text-sm"
                            placeholder="Confirm your password"
                        >
                    </div>

                    <!-- Terms Checkbox -->
                    <div class="mb-5">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" required class="w-4 h-4 text-purple-600 rounded border-gray-300 focus:ring-purple-500">
                            <span class="ml-2 text-xs text-slate-500">I agree to the <a href="#" class="text-purple-600 hover:underline">Terms & Conditions</a></span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full py-2.5 bg-purple-600 text-white rounded-lg font-semibold text-sm hover:bg-purple-700 transition shadow-md">
                        <i class="fa-solid fa-user-shield mr-1"></i> Register as Admin
                    </button>
                </form>

                <!-- Login Link -->
                <div class="mt-4 text-center">
                    <p class="text-slate-500 text-sm">Already have an account? 
                        <a href="/login" class="text-purple-600 font-semibold hover:underline">Login Here</a>
                    </p>
                </div>
            </div>

            <!-- Back to Home -->
            <div class="bg-slate-50 px-6 py-3 text-center border-t border-slate-100">
                <a href="/" class="text-slate-500 hover:text-purple-600 transition text-sm flex items-center justify-center gap-1">
                    <i class="fa-solid fa-arrow-left text-xs"></i> Back to Home
                </a>
            </div>

        </div>
    </div>

</body>
</html>