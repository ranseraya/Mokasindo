<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Vehicle;

class MyAdController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::where('user_id', Auth::id())
            ->where('status', 'approved') 
            ->with(['primaryImage', 'city'])
            ->latest()
            ->paginate(10);

        return view('pages.profile.ads', compact('vehicles'));
    }
}