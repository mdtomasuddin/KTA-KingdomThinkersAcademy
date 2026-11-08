<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - {{ config('app.name', 'Dashboard') }}</title>
    @include('backend.layouts.partials.favicon')
    <script src="{{ asset('assets/backend/vendor/tailwindcss/tailwind.min.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            '50': '#fff7ed',
                            '100': '#ffedd5',
                            '200': '#fed7aa',
                            '300': '#fdba74',
                            '400': '#fb923c',
                            '500': '#f97316',
                            '600': '#ea580c',
                            '700': '#c2410c',
                            '800': '#9a3412',
                            '900': '#7c2d12'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        * {
            font-family: 'Inter', system-ui, -apple-system, sans-serif
        }
    </style>
</head>

<body class="bg-white text-gray-900">

    <div class="min-h-screen bg-white flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-md">
    
            <div class="bg-white rounded-3xl p-8 shadow-xl border border-gray-100">
                <!-- App Logo -->
                <div class="flex justify-center mb-5">
                    <img src="{{ asset('images/applogo.png') }}" alt="{{ config('app.name', 'Logo') }}" class="h-12 w-auto object-contain">
                </div>

                <h1 class="text-2xl font-extrabold text-center">Join {{ config('app.name', 'Dashboard') }}</h1>
                <p class="text-gray-500 text-center mt-2">Create your account today</p>

                <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-5">
                    @csrf

                    <!-- First Name & Last Name -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="first_name" class="block text-sm font-medium mb-1.5">First Name *</label>
                            <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}"
                                required
                                @class([
                                    'w-full border-2 rounded-xl px-4 py-3.5 focus:border-primary-600 focus:outline-none',
                                    'border-red-400' => $errors->has('first_name'),
                                    'border-gray-200' => !$errors->has('first_name'),
                                ])
                                placeholder="First">
                            @error('first_name')
                                <p class="text-red-500 text-xs mt-1"><i
                                        class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="last_name" class="block text-sm font-medium mb-1.5">Last Name</label>
                            <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}"
                                @class([
                                    'w-full border-2 rounded-xl px-4 py-3.5 focus:border-primary-600 focus:outline-none',
                                    'border-red-400' => $errors->has('last_name'),
                                    'border-gray-200' => !$errors->has('last_name'),
                                ])
                                placeholder="Last">
                            @error('last_name')
                                <p class="text-red-500 text-xs mt-1"><i
                                        class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium mb-1.5">Phone Number *</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required
                            @class([
                                'w-full border-2 rounded-xl px-4 py-3.5 focus:border-primary-600 focus:outline-none',
                                'border-red-400' => $errors->has('phone'),
                                'border-gray-200' => !$errors->has('phone'),
                            ])
                            placeholder="01XXXXXXXXX">
                            @error('phone')
                                <p class="text-red-500 text-xs mt-1.5"><i
                                        class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                            @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium mb-1.5">Email Address *</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            @class([
                                'w-full border-2 rounded-xl px-4 py-3.5 focus:border-primary-600 focus:outline-none',
                                'border-red-400' => $errors->has('email'),
                                'border-gray-200' => !$errors->has('email'),
                            ])
                            placeholder="your@email.com">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1.5"><i
                                    class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium mb-1.5">Password *</label>
                        <div class="relative">
                            <input type="password" id="password" name="password" required minlength="8"
                                @class([
                                    'w-full border-2 rounded-xl px-4 py-3.5 focus:border-primary-600 focus:outline-none pr-12',
                                    'border-red-400' => $errors->has('password'),
                                    'border-gray-200' => !$errors->has('password'),
                                ])
                                placeholder="Minimum 8 characters">
                            <button type="button" onclick="togglePassword('password', this)"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"><i
                                    class="fa-regular fa-eye"></i></button>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1.5"><i
                                    class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Terms -->
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" required class="accent-primary-600 w-5 h-5 mt-0.5">
                        <span class="text-sm text-gray-600">I agree to the <a href="#"
                                class="text-primary-600 hover:underline">Terms of Service</a> & <a href="#"
                                class="text-primary-600 hover:underline">Privacy Policy</a></span>
                    </label>

                    <!-- Submit -->
                    <button type="submit"
                        class="w-full bg-primary-600 hover:bg-primary-700 text-white py-3.5 rounded-full font-bold text-lg transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-user-plus"></i> Create Account
                    </button>
                </form>

                <!-- Login Link -->
                <div class="mt-6 text-center">
                    <p class="text-gray-500">Already have an account? <a href="{{ route('login') }}"
                            class="text-primary-600 font-semibold hover:underline">Sign In</a></p>
                </div>
            </div>

            <p class="text-center mt-6"><a href="{{ url('/') }}"
                    class="text-gray-400 hover:text-white text-sm"><i class="fa-solid fa-arrow-left mr-1"></i> Back to
                    Home</a></p>
        </div>
    </div>

    <script>
        function togglePassword(id, btn) {
            const input = document.getElementById(id);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>

</html>
