<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // Lihat semua wishlist saya
    public function index()
    {
        // Mengambil wishlist user yang sedang login + data kendaraannya
        $wishlists = Wishlist::with('vehicle.primaryImage')
                        ->where('user_id', Auth::id())
                        ->get();

        return response()->json(['data' => $wishlists]);
    }

    // Tambah ke wishlist
    public function store(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id'
        ]);

        $wishlist = Wishlist::firstOrCreate([
            'user_id' => Auth::id(),
            'vehicle_id' => $request->vehicle_id
        ]);

        return response()->json(['message' => 'Berhasil disimpan', 'data' => $wishlist]);
    }

    // Hapus dari wishlist
    public function destroy($id)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
                        ->where('id', $id)
                        ->first();

        if ($wishlist) {
            $wishlist->delete();
            return response()->json(['message' => 'Berhasil dihapus']);
        }

        return response()->json(['message' => 'Data tidak ditemukan'], 404);
    }
}