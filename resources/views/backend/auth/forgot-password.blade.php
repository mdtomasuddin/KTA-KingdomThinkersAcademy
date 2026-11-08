<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Forgot Password - {{ config('app.name', 'Dashboard') }}</title>
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

                <h1 class="text-2xl font-extrabold text-center">Forgot Password?</h1>
                <p class="text-gray-500 text-center mt-2">No problem. Enter your email and we'll send you a reset link.
                </p>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mt-4 bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 text-sm">
                        <i class="fa-solid fa-check-circle mr-1"></i>{{ session('status') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mt-4 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm">
                        <i class="fa-solid fa-circle-exclamation mr-1"></i>{{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="mt-8 space-y-5">
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

                    <!-- Submit -->
                    <button type="submit"
                        class="w-full bg-primary-600 hover:bg-primary-700 text-white py-3.5 rounded-full font-bold transition flex items-center justify-center gap-2 shadow-lg shadow-primary-600/25">
                        <i class="fa-solid fa-paper-plane"></i> Send Link
                    </button>
                </form>

                <p class="text-center mt-6"><a href="{{ route('login') }}"
                        class="text-gray-400 hover:text-gray-600 text-sm"><i class="fa-solid fa-arrow-left mr-1"></i>
                        Back to Login</a></p>
            </div>
        </div>
    </div>

</body>

</html>
