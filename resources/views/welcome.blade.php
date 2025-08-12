<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoicer - Smart Invoicing & Client Portals</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=be-vietnam-pro:400,500,600,700,800" rel="stylesheet" />

    <!-- Scripts and Styles (Using Tailwind CDN for simplicity) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Be Vietnam Pro', sans-serif;
        }
    </style>
</head>
<body class="bg-white text-gray-800 antialiased">

    <!-- Header -->
    <header class="absolute w-full z-10">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <a href="/" class="text-2xl font-bold text-gray-900">Invoicer</a>

                <!-- Login/Register Links -->
                <div class="flex items-center space-x-6">
                    <!-- Client Login Link -->
                    <a href="{{ route('client.login.form') }}" class="text-gray-600 hover:text-gray-900 font-medium text-sm">Client Portal</a>

                    <div class="hidden sm:flex items-center space-x-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-gray-600 hover:text-gray-900 font-medium text-sm">My Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 font-medium text-sm">Business Login</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-semibold hover:bg-indigo-700 transition duration-300">
                                        Sign up your Business
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="relative bg-gray-50 pt-24 pb-20 sm:pt-32 sm:pb-24 lg:pt-40 lg:pb-32">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-900 tracking-tight">
                    Stop Chasing Payments.
                    <span class="block text-indigo-600">Start Getting Paid.</span>
                </h1>
                <p class="mt-6 max-w-2xl mx-auto text-lg text-gray-600">
                    Our smart invoicing platform automates your billing, sends reminders, and gets you paid faster with integrated mobile payments. Focus on your business, not your books.
                </p>
                <div class="mt-8 flex justify-center space-x-4">
                    <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-8 py-3 rounded-md text-base font-semibold hover:bg-indigo-700 transition duration-300">
                        Start for Your Business
                    </a>
                    <a href="#features" class="bg-white text-gray-700 px-8 py-3 rounded-md text-base font-semibold ring-1 ring-gray-200 hover:bg-gray-100 transition duration-300">
                        See Features
                    </a>
                </div>
            </div>
        </section>

        <!-- Social Proof -->
        <div class="bg-white py-8 sm:py-12">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <h2 class="text-center text-lg font-semibold leading-8 text-gray-900">
                    Trusted by the most innovative businesses in Africa
                </h2>
                <div class="mx-auto mt-10 grid max-w-lg grid-cols-4 items-center gap-x-8 gap-y-10 sm:max-w-xl sm:grid-cols-6 sm:gap-x-10 lg:mx-0 lg:max-w-none lg:grid-cols-5">
                    <!-- Replace with actual logos -->
                    <img class="col-span-2 max-h-12 w-full object-contain lg:col-span-1" src="https://tailwindui.com/img/logos/158x48/transistor-logo-gray-900.svg" alt="Transistor">
                    <img class="col-span-2 max-h-12 w-full object-contain lg:col-span-1" src="https://tailwindui.com/img/logos/158x48/reform-logo-gray-900.svg" alt="Reform">
                    <img class="col-span-2 max-h-12 w-full object-contain lg:col-span-1" src="https://tailwindui.com/img/logos/158x48/tuple-logo-gray-900.svg" alt="Tuple">
                    <img class="col-span-2 max-h-12 w-full object-contain sm:col-start-2 lg:col-span-1" src="https://tailwindui.com/img/logos/158x48/savvycal-logo-gray-900.svg" alt="SavvyCal">
                    <img class="col-span-2 col-start-2 max-h-12 w-full object-contain sm:col-start-auto lg:col-span-1" src="https://tailwindui.com/img/logos/158x48/statamic-logo-gray-900.svg" alt="Statamic">
                </div>
            </div>
        </div>

        <!-- Features Grid -->
        <section id="features" class="bg-gray-50 py-20 sm:py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-base font-semibold text-indigo-600 tracking-wide uppercase">Features</h2>
                    <p class="mt-2 text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">
                        Everything you need to streamline your finances
                    </p>
                </div>
                <div class="mt-12 grid gap-10 md:grid-cols-2 lg:grid-cols-3">
                    <!-- Feature 1: Effortless Invoicing -->
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </div>
                        <h3 class="mt-5 text-lg font-medium text-gray-900">Effortless Invoicing</h3>
                        <p class="mt-2 text-base text-gray-600">Create and send professional invoices in seconds. Add line items, taxes, and discounts with ease.</p>
                    </div>
                    <!-- Feature 2: SMS & Mobile Payments -->
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                        </div>
                        <h3 class="mt-5 text-lg font-medium text-gray-900">SMS & Mobile Payments</h3>
                        <p class="mt-2 text-base text-gray-600">Notify clients via SMS and let them pay directly from their phone with integrated mobile money.</p>
                    </div>
                    <!-- Feature 3: Client Portals -->
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                            <!-- Heroicon: users -->
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-4.67c.12-.241.252-.477.388-.704m-15.584 4.67a6.375 6.375 0 01-1.196-4.67c.12-.241.252-.477.388-.704m15.584 4.67c-.136.227-.268.463-.388.704m-11.964-4.67a9.375 9.375 0 018.868-1.432M4.5 19.382c-.383.27-.734.554-1.05.852A9.337 9.337 0 004.121 21a9.337 9.337 0 002.625-.372M19.5 19.382c.383.27.734.554 1.05.852A9.337 9.337 0 0119.88 21a9.337 9.337 0 01-2.625-.372" /></svg>
                        </div>
                        <h3 class="mt-5 text-lg font-medium text-gray-900">Self-Service Client Portals</h3>
                        <p class="mt-2 text-base text-gray-600">Empower your clients to view their invoice history and payment status, reducing your support overhead.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Detailed Feature Section 1 -->
        <section class="bg-white py-20 sm:py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Get Paid Instantly with Mobile Money</h2>
                    <p class="mt-4 text-lg text-gray-600">
                        Our integration with Africa's Talking allows your clients to pay invoices with a single tap on their phone. Payments are automatically reconciled, and your invoice status is updated in real-time. No more manual tracking.
                    </p>
                </div>
                <div>
                    <!-- Replace with your own screenshot -->
                    <img src="https://placehold.co/1000x800/E2E8F0/4A5568?text=App+Screenshot+Here" alt="Mobile Payment Screenshot" class="rounded-lg shadow-lg">
                </div>
            </div>
        </section>

        <!-- Final CTA Section -->
        <section class="bg-indigo-700">
            <div class="max-w-4xl mx-auto text-center py-16 px-4 sm:py-20 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                    <span class="block">Ready to transform your billing?</span>
                </h2>
                <p class="mt-4 text-lg leading-6 text-indigo-200">
                    Sign up today and send your first invoice in minutes. No credit card required.
                </p>
                <a href="{{ route('register') }}" class="mt-8 w-full inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50 sm:w-auto">
                    Sign up your Business for free
                </a>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <nav class="-mx-5 -my-2 flex flex-wrap justify-center" aria-label="Footer">
                <div class="px-5 py-2">
                    <a href="#features" class="text-base text-gray-400 hover:text-white">Features</a>
                </div>
                <div class="px-5 py-2">
                    <a href="#" class="text-base text-gray-400 hover:text-white">Pricing</a>
                </div>
                <div class="px-5 py-2">
                    <a href="{{ route('client.login.form') }}" class="text-base text-gray-400 hover:text-white">Client Portal</a>
                </div>
            </nav>
            <div class="mt-8 flex justify-center space-x-6">
                <!-- Replace with your social media links -->
                <a href="#" class="text-gray-400 hover:text-white">
                    <span class="sr-only">Twitter</span>
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.71v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path>
                    </svg>
                </a>
                <a href="#" class="text-gray-400 hover:text-white">
                    <span class="sr-only">GitHub</span>
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.477 2 12c0 4.418 2.865 8.168 6.839 9.49.5.092.682-.217.682-.482 0-.237-.009-.868-.014-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.031-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.203 2.398.1 2.651.64.7 1.03 1.595 1.03 2.688 0 3.848-2.338 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.003 10.003 0 0022 12c0-5.523-4.477-10-10-10z" clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
            <p class="mt-8 text-center text-base text-gray-400">&copy; {{ date('Y') }} Invoicer, Inc. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
