<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    // 1. GET LIST MOBIL (Pencarian & Filter)
    public function index(Request $request)
    {
        // Start Query: Hanya ambil yang statusnya 'approved'
        $query = Vehicle::approved()
            ->with(['primaryImage', 'city', 'auction', 'province']); // Load relasi biar data lengkap

        // A. Search Keyword (Cari di Brand, Model, atau Deskripsi)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('brand', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // B. Filter Kategori (Motor/Mobil)
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // C. Filter Harga Range
        if ($request->filled('min_price')) {
            $query->where('starting_price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('starting_price', '<=', $request->max_price);
        }

        // D. Filter Lokasi (Kota)
        if ($request->filled('city_id')) {
            $query->where('city_id', $request->city_id);
        }

        // E. Sorting (Urutan)
        $sort = $request->input('sort', 'latest');
        if ($sort === 'cheapest') {
            $query->orderBy('starting_price', 'asc');
        } elseif ($sort === 'expensive') {
            $query->orderBy('starting_price', 'desc');
        } else {
            $query->latest('approved_at'); // Default: Terbaru
        }

        // Eksekusi (12 item per halaman)
        return response()->json([
            'status' => 'success',
            'data' => $query->paginate(12)
        ]);
    }

    // 2. GET DETAIL SATU MOBIL
    public function show($id)
    {
        $vehicle = Vehicle::approved()
            ->with(['images', 'user', 'city', 'province', 'auction', 'district'])
            ->find($id);

        if (!$vehicle) {
            return response()->json(['message' => 'Kendaraan tidak ditemukan atau belum tayang'], 404);
        }

        // Tambah views count
        $vehicle->incrementViews();

        return response()->json([
            'status' => 'success',
            'data' => $vehicle
        ]);
    }

    // 3. GET DATA FILTERS (Untuk Dropdown di Frontend)
    public function filters()
    {
        // Ambil list Brand yang unik dari database
        $brands = Vehicle::approved()
                    ->select('brand')
                    ->distinct()
                    ->orderBy('brand')
                    ->pluck('brand');

        return response()->json([
            'brands' => $brands,
            'categories' => ['mobil', 'motor'], // Manual karena enum
        ]);
    }
}