<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Web App') }}</title>

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /* Body */
                .body {
                    background-color: #f3f4f6; /* gray-100 */
                    min-height: 100vh;
                }

                /* Headings */
                .h-2 {
                    font-size: 1.25rem; /* text-xl */
                    font-weight: 700;
                    color: #1f2937; /* gray-800 */
                    margin-bottom: 2rem;
                }

                @media (min-width: 640px) {
                    .h-2 {
                        font-size: 1.5rem; /* sm:text-2xl */
                        margin-bottom: 2rem;
                    }
                }

                .h-3 {
                    font-size: 1rem; /* text-base */
                    font-weight: 600;
                    color: #374151; /* gray-700 */
                    margin-bottom: 2rem;
                }

                @media (min-width: 640px) {
                    .h-3 {
                        font-size: 1.125rem; /* sm:text-lg */
                    }
                }

                /* Text */
                .txt {
                    color: #4b5563; /* gray-600 */
                }

                /* Input */
                .input-field {
                    background-color: #ffffff;
                    width: 100%;
                    border: 1px solid #d1d5db; /* gray-300 */
                    border-radius: 0.375rem;
                    padding: 0.5rem 0.75rem;
                    outline: none;
                }

                .input-field:focus {
                    outline: none;
                    border-color: #3b82f6; /* blue-500 */
                    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
                }

                /* Button Base */
                .button {
                    font-weight: 500;
                    padding: 0.25rem 1rem;
                    border-radius: 0.375rem;
                    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
                    transition: all 0.2s ease;
                }

                /* Form Card */
                .form-card {
                    background-color: #ffffff;
                    padding: 2rem;
                    border-radius: 0.5rem;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                    width: 100%;
                    max-width: 28rem;
                    margin: 1rem;
                }

                /* Error Text */
                .text-error {
                    color: #ef4444; /* red-500 */
                    margin-top: 0.25rem;
                    font-size: 0.875rem;
                }

                /* Primary Button */
                .btn-primary {
                    background-color: #3b82f6;
                    color: #ffffff;
                    font-weight: 500;
                    padding: 0.5rem 1rem;
                    border-radius: 0.375rem;
                    transition: all 0.2s ease;
                    border: none;
                    cursor: pointer;
                }

                .btn-primary:hover {
                    background-color: #2563eb; /* blue-600 */
                }

                /* Back Button */
                .btn-back {
                    display: inline-block;
                    text-align: center;
                    padding: 0.5rem 1rem;
                    color: #3b82f6;
                    border: 1px solid #9ca3af; /* gray-400 */
                    border-radius: 0.375rem;
                    transition: all 0.2s ease;
                    text-decoration: none;
                }

                .btn-back:hover {
                    background-color: #f3f4f6;
                }

                /* Delete Button */
                .btn-delete {
                    background-color: #ef4444;
                    color: white;
                    padding: 0.25rem 0.75rem;
                    border-radius: 0.375rem;
                    font-size: 0.875rem;
                    transition: all 0.2s ease;
                    border: none;
                    cursor: pointer;
                }

                .btn-delete:hover {
                    background-color: #dc2626; /* red-600 */
                }

                /* Edit Button */
                .btn-edit {
                    background-color: #3b82f6;
                    color: white;
                    padding: 0.25rem 0.75rem;
                    border-radius: 0.375rem;
                    font-size: 0.875rem;
                    transition: all 0.2s ease;
                    border: none;
                    cursor: pointer;
                }

                .btn-edit:hover {
                    background-color: #2563eb;
                }

                /* Label */
                .label {
                    display: block;
                    color: #374151;
                    font-weight: 500;
                    margin-bottom: 0.25rem;
                }

                /* Primary Link */
                .link-primary {
                    color: #3b82f6;
                    text-decoration: none;
                }

                .link-primary:hover {
                    text-decoration: underline;
                }

                /* Fade Out Animation */
                @keyframes fadeOut {
                0%   { opacity: 1; }
                80%  { opacity: 1; }
                100% { opacity: 0; }
                }

                /* Success Alert */
                .success-alert {
                    position: fixed;
                    top: 1.25rem;
                    left: 50%;
                    transform: translateX(-50%);
                    z-index: 50;
                    margin-top: 1.5rem;
                    padding: 0.25rem 1rem;
                    background-color: #d1fae5; /* green-100 */
                    color: #047857; /* green-700 */
                    text-align: center;
                    border-radius: 9999px;
                    border: 1px solid #6ee7b7; /* green-300 */
                    animation: fadeOut 2s ease-in-out forwards;
                }

                /* Error Alert */
                .error-alert {
                    position: fixed;
                    top: 1.25rem;
                    left: 50%;
                    transform: translateX(-50%);
                    z-index: 50;
                    margin-top: 1.5rem;
                    padding: 0.25rem 1rem;
                    background-color: #fee2e2; /* red-100 */
                    color: #b91c1c; /* red-700 */
                    text-align: center;
                    border-radius: 9999px;
                    border: 1px solid #fca5a5; /* red-300 */
                    animation: fadeOut 2s ease-in-out forwards;
                }

                /* Table */
                .table-base {
                    min-width: 100%;
                    border-collapse: collapse;
                }

                .table-base > :not([hidden]) ~ :not([hidden]) {
                    border-top: 1px solid #e5e7eb; /* gray-200 */
                }

                .table-head {
                    background-color: #f9fafb; /* gray-50 */
                }

                .th {
                    padding: 0.75rem 1.5rem;
                    text-align: left;
                    font-size: 0.75rem;
                    font-weight: 500;
                    color: #6b7280; /* gray-500 */
                    text-transform: uppercase;
                    letter-spacing: 0.05em;
                }

                .td {
                    padding: 1rem 1.5rem;
                    white-space: nowrap;
                    color: #374151; /* gray-700 */
                }
                .flex-grow {
                    flex-grow: 1;
                }

                .flex {
                    display: flex;
                }

                .justify-center {
                    justify-content: center;
                }

                .mt-8 {
                    margin-top: 2rem;
                }
                .py-8 {
                    padding-top: 2rem;
                    padding-bottom: 2rem;
                }

                .p-2 {
                    padding: 0.5rem;
                }

                .px-3 {
                    padding-left: 0.75rem;
                    padding-right: 0.75rem;
                }

                .py-1 {
                    padding-top: 0.25rem;
                    padding-bottom: 0.25rem;
                }

                .mt-6 {
                    margin-top: 1.5rem;
                }

                .mx-1 {
                    margin-left: 0.25rem;
                    margin-right: 0.25rem;
                }

                .mx-auto {
                    margin-left: auto;
                    margin-right: auto;
                }

                .gap-4 {
                    gap: 1rem;
                }

                .w-full {
                    width: 100%;
                }

                @media (min-width: 640px) {
                    .sm-w-1-3 {
                        width: 33.333333%;
                    }
                }
                .block {
                    display: block;
                }

                .flex {
                    display: flex;
                }

                .items-center {
                    align-items: center;
                }

                .justify-center {
                    justify-content: center;
                }

                .justify-between {
                    justify-content: space-between;
                }
                .text-center {
                    text-align: center;
                }

                .text-gray {
                    color: #6b7280; /* Tailwind gray-500 */
                }

                .font-medium {
                    font-weight: 500;
                }
                .bg-white {
                    background-color: #ffffff;
                }

                .bg-blue-300 {
                    background-color: #93c5fd;
                }

                .hover-bg-blue-600:hover {
                    background-color: #2563eb;
                }

                .hover-text-white:hover {
                    color: #ffffff;
                }
                .rounded {
                    border-radius: 0.375rem;
                }

                .transition {
                    transition: all 0.2s ease;
                }
                .container {
                    width: 100%;
                    margin-left: auto;
                    margin-right: auto;
                }

                /* Default container max-widths (Tailwind-like) */
                @media (min-width: 640px) {
                    .container {
                        max-width: 640px;
                    }
                }
                @media (min-width: 768px) {
                    .container {
                        max-width: 768px;
                    }
                }
                @media (min-width: 1024px) {
                    .container {
                        max-width: 1024px;
                    }
                }
                @media (min-width: 1280px) {
                    .container {
                        max-width: 1280px;
                    }
                }

            </style>
        @endif
    </head>
    <body class="body">
        <header>
            @include('components.navbar')
        </header>
        <main class="flex-grow">
            @yield('content')
        </main>
        <footer class="flex justify-center mt-8">
            <!--  -->
        </footer>
    </body>
</html>
