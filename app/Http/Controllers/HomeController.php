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
            ->with(['translations', 'destination.translations'])
            ->latest()
            ->get();

        $destinations = Destination::where('status', true)
            ->with(['translations'])
            ->orderBy('sort', 'asc')
            ->get();

        return view('home.index', compact('properties', 'destinations'));
    }

    /**
     * Display the wisata (tourist destinations) page.
     */
    public function wisata(Request $request)
    {
        $selectedRegion = $request->query('region');

        $allDestinations = Destination::where('status', true)
            ->with(['translations'])
            ->orderBy('sort', 'asc')
            ->get();

        $destinationsQuery = Destination::where('status', true)
            ->with(['translations', 'properties' => function ($q) {
                $q->where('status', true)->with(['translations'])->latest();
            }])
            ->orderBy('sort', 'asc');

        if ($selectedRegion) {
            $destinationsQuery->where(function ($q) use ($selectedRegion) {
                $q->where('slug', $selectedRegion)
                  ->orWhere('name', 'like', '%' . $selectedRegion . '%');
            });
        }

        $destinations = $destinationsQuery->get();

        return view('wisata.index', compact('destinations', 'allDestinations', 'selectedRegion'));
    }

    /**
     * Display the services / amenities page.
     */
    public function layanan()
    {
        return view('layanan.index');
    }
}
