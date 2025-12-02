<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Mokasindo - Lelang Mobil & Motor Bekas Indonesia' }}</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">

    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center h-16">
                
                <div class="flex-shrink-0">
                    <a href="/" class="text-2xl font-bold text-indigo-600 tracking-tighter hover:text-indigo-700 transition">
                        Mokasindo
                    </a>
                </div>

                <div class="hidden md:flex md:flex-1 md:justify-center md:space-x-8">
                    <a href="/" class="font-medium transition px-2 py-1 {{ request()->is('/') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-700 hover:text-indigo-600' }}">
                        Beranda
                    </a>
                    <a href="/about" class="font-medium transition px-2 py-1 {{ request()->is('about*') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-700 hover:text-indigo-600' }}">
                        Tentang
                    </a>
                    <a href="/contact" class="font-medium transition px-2 py-1 {{ request()->is('contact*') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-700 hover:text-indigo-600' }}">
                        Kontak
                    </a>
                </div>

                <div class="ml-auto flex items-center space-x-4">
                    
                    <button onclick="detectLocation()" class="hidden md:flex items-center gap-1 text-gray-600 hover:text-indigo-600 transition border border-gray-200 rounded-full px-3 py-1.5 text-sm hover:border-indigo-300 bg-white" title="Atur Lokasi Saya">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span id="user-location-label" class="font-medium">Lokasi</span>
                    </button>

                    <div class="h-6 w-px bg-gray-200 hidden md:block"></div>

                    @auth
                        <div class="relative group z-50">
                            <button type="button" class="bg-white rounded-full flex text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                <span class="sr-only">Open user menu</span>
                                
                                <img id="nav-avatar-img" 
                                    class="h-8 w-8 rounded-full object-cover {{ Auth::user()->avatar ? '' : 'hidden' }}" 
                                    src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : '#' }}" 
                                    alt="{{ Auth::user()->name }}">

                                <div id="nav-avatar-initial" 
                                    class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs {{ Auth::user()->avatar ? 'hidden' : '' }}">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            </button>
                            <div class="dropdown-menu absolute right-0 mt-0 w-60 bg-white rounded-xl shadow-2xl border border-gray-100 py-2 opacity-0 invisible transform scale-95 transition-all duration-200 group-hover:opacity-100 group-hover:visible group-hover:scale-100 origin-top-right">
                                
                                <div class="px-4 py-3 border-b border-gray-100 bg-gray-50 rounded-t-xl">
                                    <p class="text-xs text-gray-500 font-medium">Masuk sebagai</p>
                                    <p class="text-sm font-bold text-gray-800 truncate" title="{{ Auth::user()->email }}">
                                        {{ Auth::user()->email }}
                                    </p>
                                </div>
                                
                                <div class="py-1">
                                    <a href="{{ route('profile.edit') }}" class="group flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
                                        <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Edit Profil
                                    </a>

                                    <a href="{{ route('profile.password.edit') }}" class="group flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
                                        <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                        Ganti Password
                                    </a>
                                    <a href="{{ route('my.ads') }}" class="group flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
                                        <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                        Iklan Saya
                                    </a>
                                </div>

                                <div class="border-t border-gray-100 my-1"></div>
                                
                                <form action="{{ route('logout') }}" method="POST" class="block">
                                    @csrf
                                    <button type="submit" class="w-full group flex items-center px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition">
                                        <svg class="mr-3 h-5 w-5 text-red-400 group-hover:text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>

                    @else
                        <div class="flex items-center gap-3">
                            <a href="{{ route('login.form') }}" class="text-sm font-semibold text-gray-600 hover:text-indigo-600 transition">Masuk</a>
                            <a href="{{ route('register.form') }}" class="text-sm font-semibold bg-indigo-600 text-white px-5 py-2.5 rounded-full hover:bg-indigo-700 shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">Daftar</a>
                        </div>
                    @endauth

                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="bg-gray-900 text-white py-12 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-2xl font-bold text-indigo-400 mb-4">Mokasindo</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Platform lelang otomotif nomor #1 di Indonesia.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4 text-lg">Perusahaan</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('company.about') }}" class="text-gray-400 hover:text-white transition">Tentang Kami</a></li>
                        <li><a href="{{ route('company.career') }}" class="text-gray-400 hover:text-white transition">Karir</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Blog</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4 text-lg">Bantuan</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('company.faq') }}" class="text-gray-400 hover:text-white transition">FAQ</a></li>
                        <li><a href="{{ route('company.how_it_works')}}" class="text-gray-400 hover:text-white transition">Cara Lelang</a></li>
                        <li><a href="{{ route('company.contact') }}" class="text-gray-400 hover:text-white transition">Kontak</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4 text-lg">Legal</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('company.terms') }}" class="text-gray-400 hover:text-white transition">Syarat & Ketentuan</a></li>
                        <li><a href="{{ route('company.privacy') }}" class="text-gray-400 hover:text-white transition">Kebijakan Privasi</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-400 text-sm">
                <p>&copy; {{ date('Y') }} Mokasindo. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>