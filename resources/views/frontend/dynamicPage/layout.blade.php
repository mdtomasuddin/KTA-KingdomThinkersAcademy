<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'Legal Page'))</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS (Local Offline) -->
    <script src="{{ asset('assets/backend/vendor/tailwindcss/tailwind.min.js') }}"></script>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Figtree', system-ui, -apple-system, sans-serif;
            background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
            min-height: 100vh;
            color: #1e293b;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }

        /* Reading Progress Bar */
        #reading-progress {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            background: linear-gradient(90deg, #00A3FF, #0284c7);
            width: 0%;
            z-index: 9999;
            transition: width 0.1s ease-out;
        }

        .legal-container {
            max-width: 880px;
            margin: 0 auto;
            padding: 2.5rem 1.25rem 4rem;
        }

        .legal-card {
            background: #ffffff;
            border-radius: 1.25rem;
            padding: 3rem 2.75rem;
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.04), 0 4px 12px -2px rgba(0, 0, 0, 0.02);
            border: 1px solid #e2e8f0;
        }

        @media (max-width: 640px) {
            .legal-container {
                padding: 1.25rem 0.875rem 2.5rem;
            }

            .legal-card {
                padding: 1.75rem 1.25rem;
                border-radius: 1rem;
            }
        }

        .page-header {
            margin-bottom: 2.25rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .badge-wrapper {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.625rem;
            margin-bottom: 1.25rem;
        }

        .type-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.35rem 0.85rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            background-color: #e0f2fe;
            color: #0284c7;
        }

        .updated-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.35rem 0.85rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            background-color: #f1f5f9;
            color: #64748b;
        }

        .page-title {
            font-size: 2.25rem;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.2;
            letter-spacing: -0.02em;
            margin: 0 0 0.625rem;
        }

        @media (max-width: 640px) {
            .page-title {
                font-size: 1.75rem;
            }
        }

        .app-subtext {
            font-size: 0.95rem;
            color: #64748b;
            margin: 0;
            line-height: 1.5;
        }

        .app-subtext strong {
            color: #334155;
            font-weight: 600;
        }

        /* Legal HTML Content Typography */
        .legal-content {
            font-size: 1rem;
            line-height: 1.85;
            color: #334155;
            word-break: break-word;
        }

        .legal-content h1,
        .legal-content h2,
        .legal-content h3,
        .legal-content h4,
        .legal-content h5,
        .legal-content h6 {
            color: #0f172a;
            font-weight: 700;
            letter-spacing: -0.01em;
            margin-top: 2rem;
            margin-bottom: 0.75rem;
            line-height: 1.35;
        }

        .legal-content h1 { font-size: 1.625rem; }
        .legal-content h2 { font-size: 1.375rem; }
        .legal-content h3 { font-size: 1.2rem; }
        .legal-content h4 { font-size: 1.075rem; }

        .legal-content p {
            margin: 0 0 1.25rem;
        }

        .legal-content ul,
        .legal-content ol {
            margin: 0.75rem 0 1.25rem;
            padding-left: 1.625rem;
        }

        .legal-content ul {
            list-style-type: disc;
        }

        .legal-content ol {
            list-style-type: decimal;
        }

        .legal-content li {
            margin-bottom: 0.5rem;
            line-height: 1.75;
        }

        .legal-content a {
            color: #0284c7;
            text-decoration: underline;
            text-underline-offset: 3px;
            transition: color 0.15s ease;
        }

        .legal-content a:hover {
            color: #0369a1;
        }

        .legal-content strong {
            color: #0f172a;
            font-weight: 700;
        }

        .legal-content blockquote {
            border-left: 4px solid #00A3FF;
            padding: 0.75rem 1.25rem;
            margin: 1.5rem 0;
            background-color: #f8fafc;
            border-radius: 0 0.5rem 0.5rem 0;
            color: #475569;
            font-style: italic;
        }

        .legal-content table {
            width: 100%;
            border-collapse: collapse;
            margin: 1.5rem 0;
            font-size: 0.95rem;
        }

        .legal-content table th,
        .legal-content table td {
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
            text-align: left;
        }

        .legal-content table th {
            background-color: #f8fafc;
            font-weight: 600;
            color: #0f172a;
        }

        /* Support Contact Box */
        .support-box {
            margin-top: 3rem;
            padding: 1.75rem;
            border-radius: 1rem;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border: 1px solid #e2e8f0;
            position: relative;
        }

        .support-box h4 {
            font-size: 1.1rem;
            font-weight: 700;
            color: #0f172a;
            margin: 0 0 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .support-box p {
            font-size: 0.95rem;
            color: #64748b;
            margin: 0;
            line-height: 1.65;
        }

        .support-box a {
            color: #0284c7;
            font-weight: 600;
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        .support-box a:hover {
            color: #0369a1;
        }

        /* Print styles */
        @media print {
            body {
                background: #ffffff;
                color: #000000;
            }

            .legal-card {
                box-shadow: none;
                border: none;
                padding: 0;
            }

            #reading-progress,
            footer {
                display: none !important;
            }
        }
    </style>
</head>

<body>
    <!-- Top Reading Progress Indicator -->
    <div id="reading-progress"></div>

    <!-- Main Content Container -->
    <main class="legal-container">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="text-center pb-10 text-sm text-gray-400">
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </footer>

    <script>
        // Reading scroll progress
        window.addEventListener('scroll', function() {
            const docElement = document.documentElement;
            const docBody = document.body;
            const scrollTop = docElement['scrollTop'] || docBody['scrollTop'];
            const scrollBottom = (docElement['scrollHeight'] || docBody['scrollHeight']) - window.innerHeight;
            const scrollPercent = scrollBottom > 0 ? (scrollTop / scrollBottom) * 100 : 0;
            document.getElementById('reading-progress').style.width = scrollPercent + '%';
        });
    </script>
</body>

</html>
