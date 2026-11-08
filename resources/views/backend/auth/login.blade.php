<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - {{ config('app.name', 'Dashboard') }}</title>
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

                <h1 class="text-2xl font-extrabold text-center">Welcome Back to {{ config('app.name', 'Dashboard') }}!</h1>
                <p class="text-gray-500 text-center mt-2">Sign in to your {{ config('app.name', 'Dashboard') }} account</p>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mt-4 bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 text-sm">
                        <i class="fa-solid fa-check-circle mr-1"></i>{{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium mb-1.5">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            autofocus
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
                        <label for="password" class="block text-sm font-medium mb-1.5">Password</label>
                        <div class="relative">
                            <input type="password" id="password" name="password" required
                                @class([
                                    'w-full border-2 rounded-xl px-4 py-3.5 focus:border-primary-600 focus:outline-none pr-12',
                                    'border-red-400' => $errors->has('password'),
                                    'border-gray-200' => !$errors->has('password'),
                                ])
                                placeholder="••••••••">
                            <button type="button" onclick="togglePassword('password', this)"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"><i
                                    class="fa-regular fa-eye"></i></button>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1.5"><i
                                    class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember" class="accent-primary-600 w-4 h-4"> <span
                                class="text-sm text-gray-600">Remember me</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="text-sm text-primary-600 hover:underline">Forgot Password?</a>
                        @endif
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                        class="w-full bg-primary-600 hover:bg-primary-700 text-white py-3.5 rounded-full font-bold text-lg transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i> Sign In
                    </button>
                </form>

                {{-- <!-- Register Link -->
                <div class="mt-6 text-center">
                    <p class="text-gray-500">Don't have an account? <a href="{{ route('register') }}"
                            class="text-primary-600 font-semibold hover:underline">Register</a></p>
                </div> --}}
            </div>

            <p class="text-center mt-6"><a href="{{ url('/') }}" class="text-gray-500 hover:text-primary-600 text-sm font-medium transition"><i
                        class="fa-solid fa-arrow-left mr-1"></i> Back to Home</a></p>
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
