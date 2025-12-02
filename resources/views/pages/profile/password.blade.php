@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Keamanan Akun</h1>
        <p class="text-gray-500 text-sm mt-1">Lindungi akun Anda dengan kata sandi yang kuat</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        
        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50">
            <h2 class="text-lg font-bold text-gray-900">Ganti Password</h2>
            <p class="text-xs text-gray-500 mt-1">Pastikan password baru Anda aman dan tidak mudah ditebak.</p>
        </div>

        @if(session('success'))
            <div class="px-6 pt-6">
                <div class="bg-green-50 text-green-800 px-4 py-3 rounded-lg text-sm flex items-center gap-2 border border-green-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <div class="md:col-span-1">
                    <div class="bg-indigo-50 rounded-xl p-6 border border-indigo-100">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2 bg-indigo-100 rounded-lg text-indigo-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <h3 class="font-bold text-gray-900 text-sm">Tips Keamanan</h3>
                        </div>
                        <ul class="text-sm text-gray-600 space-y-3 list-disc list-inside">
                            <li>Gunakan minimal 8 karakter.</li>
                            <li>Kombinasikan huruf besar, huruf kecil, dan angka.</li>
                            <li>Jangan gunakan password yang sama dengan situs lain.</li>
                            <li>Ganti password secara berkala.</li>
                        </ul>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <form action="{{ route('profile.password') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi Saat Ini</label>
                            <input type="password" name="current_password" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2.5">
                            @error('current_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <hr class="border-gray-100">

                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi Baru</label>
                                <input type="password" name="password" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2.5">
                                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Ulangi Kata Sandi Baru</label>
                                <input type="password" name="password_confirmation" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2.5">
                            </div>
                        </div>

                        <div class="flex justify-end pt-4">
                            <button type="submit" class="bg-indigo-600 text-white px-6 py-2.5 rounded-lg font-medium hover:bg-indigo-700 transition shadow-sm">
                                Simpan Password Baru
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection