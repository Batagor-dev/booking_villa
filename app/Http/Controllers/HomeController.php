<?php

namespace App\Http\Controllers;

use App\Models\Properties;
use App\Models\Destination;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the public homepage with properties and destinations.
     */
    public function index()
    {
        $properties = Properties::where('status', true)
            ->latest()
            ->get();

        $destinations = Destination::where('status', true)
            ->orderBy('sort', 'asc')
            ->get();

        return view('home.index', compact('properties', 'destinations'));
    }

    /**
     * Display the wisata (tourist destinations) page.
     */
    public function wisata()
    {
        return view('wisata.index');
    }

    /**
     * Display the services / amenities page.
     */
    public function layanan()
    {
        return view('layanan.index');
    }
}
