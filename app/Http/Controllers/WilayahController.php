<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\District;
use App\Models\SubDistrict;

class WilayahController extends Controller
{
    public function cities(Request $request)
    {
        // Tangkap ID Provinsi dari Javascript
        $province_id = $request->input('province_id');

        if (!$province_id) {
            return response()->json([]);
        }

        // Ambil Kota berdasarkan Provinsi
        $cities = City::where('province_id', $province_id)
                      ->orderBy('name', 'ASC')
                      ->get(['id', 'name']);

        return response()->json($cities);
    }

    public function districts(Request $request)
    {
        // Tangkap ID Kota
        $city_id = $request->input('city_id');

        if (!$city_id) {
            return response()->json([]);
        }

        // Ambil Kecamatan berdasarkan Kota
        $districts = District::where('city_id', $city_id)
                             ->orderBy('name', 'ASC')
                             ->get(['id', 'name']);

        return response()->json($districts);
    }

    public function subdistricts(Request $request)
    {
        // Tangkap ID Kecamatan
        $district_id = $request->input('district_id');

        if (!$district_id) {
            return response()->json([]);
        }

        // Ambil Kelurahan DAN Kode Pos
        $subDistricts = SubDistrict::where('district_id', $district_id)
                                   ->orderBy('name', 'ASC')
                                   ->get(['id', 'name', 'postal_code']); // <--- Penting: Ambil postal_code juga

        return response()->json($subDistricts);
    }
}