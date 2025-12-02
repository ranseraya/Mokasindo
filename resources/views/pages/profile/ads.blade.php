@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Iklan Saya</h1>
            <p class="text-gray-500 text-sm mt-1">Daftar iklan kendaraan Anda yang sedang tayang.</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        
        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
            <h2 class="text-lg font-bold text-gray-900">Daftar Kendaraan</h2>
            <span class="text-xs text-gray-500 font-medium bg-white px-3 py-1 rounded-full border border-gray-200 shadow-sm">{{ $vehicles->total() ?? 0 }} Unit Tayang</span>
        </div>

        <div class="divide-y divide-gray-100">
            @forelse($vehicles as $vehicle)
                <div class="p-6 flex flex-col md:flex-row gap-6 hover:bg-gray-50 transition group items-start md:items-center">
                    
                    <div class="w-full md:w-56 h-40 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0 relative border border-gray-100">
                        @if($vehicle->primaryImage)
                            <img src="{{ asset('storage/' . $vehicle->primaryImage->image_path) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400 flex-col">
                                <svg class="w-10 h-10 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span class="text-xs">No Image</span>
                            </div>
                        @endif
                    </div>

                    <div class="flex-1 w-full">
                        <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-2 mb-2">
                            <div>
                                <h3 class="font-bold text-gray-900 text-xl group-hover:text-indigo-600 transition">
                                    {{ $vehicle->brand }} {{ $vehicle->model }} 
                                    <span class="text-gray-400 font-normal text-lg ml-1">{{ $vehicle->year }}</span>
                                </h3>
                                <p class="text-sm text-gray-500 line-clamp-1 mt-1">{{ Str::limit($vehicle->description, 150) }}</p>
                            </div>
                            <div class="text-left md:text-right">
                                <p class="text-indigo-600 font-bold text-xl">Rp {{ number_format($vehicle->starting_price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        
                        <div class="flex flex-wrap items-center gap-4 mt-4 text-sm text-gray-500">
                            <div class="flex items-center gap-1.5 bg-gray-50 px-3 py-1 rounded-full border border-gray-100">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span>Tayang: {{ $vehicle->created_at->format('d M Y') }}</span>
                            </div>
                            <div class="flex items-center gap-1.5 bg-gray-50 px-3 py-1 rounded-full border border-gray-100">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span>{{ $vehicle->city->name ?? 'Lokasi -' }}</span>
                            </div>
                            <div class="flex items-center gap-1.5 bg-gray-50 px-3 py-1 rounded-full border border-gray-100">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                <span>{{ $vehicle->views_count ?? 0 }} Views</span>
                            </div>
                        </div>
                    </div>

                    <div class="w-full md:w-auto flex flex-row md:flex-col gap-3 mt-2 md:mt-0">
                        <a href="{{ url('/etalase/vehicles/' . $vehicle->id) }}" class="flex-1 md:flex-none inline-flex items-center justify-center px-4 py-2 bg-indigo-50 border border-indigo-100 text-indigo-600 rounded-lg text-sm font-medium hover:bg-indigo-100 transition whitespace-nowrap">
                            Lihat Iklan
                        </a>
                        <a href="#" class="flex-1 md:flex-none inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition whitespace-nowrap">
                            Edit Data
                        </a>
                    </div>
                </div>
            @empty
                <div class="py-20 text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-indigo-50 mb-6">
                        <svg class="w-10 h-10 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Belum ada iklan tayang</h3>
                    
                </div>
            @endforelse
        </div>
        
        @if($vehicles->hasPages())
            <div class="p-4 border-t border-gray-100 bg-gray-50">
                {{ $vehicles->links() }}
            </div>
        @endif
    </div>
</div>
@endsection