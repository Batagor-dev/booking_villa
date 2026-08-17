<?php

namespace App\Http\Controllers;

use App\Models\Properties;
use App\Models\Destination;
use App\Models\PaymentMethod;
use App\Models\PropertyRule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VillaController extends Controller
{
    /**
     * Display public villa catalog with search and filters.
     */
    public function index(Request $request)
    {
        $query = Properties::where('status', true)->with(['translations', 'destination.translations', 'promotions']);

        // 1. Keyword search (name, address, city, description, and multi-language translations)
        if ($request->filled('q') || $request->filled('search')) {
            $keyword = trim($request->input('q', $request->input('search')));
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('address', 'like', "%{$keyword}%")
                  ->orWhere('city', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%")
                  ->orWhereHas('translations', function ($tQ) use ($keyword) {
                      $tQ->where('name', 'like', "%{$keyword}%")
                         ->orWhere('description', 'like', "%{$keyword}%");
                  });
            });
        }

        // 2. Filter by Location (Extracted dynamically from property cities)
        if ($request->filled('location')) {
            $location = strtolower(trim($request->input('location')));
            $query->where(function ($q) use ($location) {
                $q->whereRaw('LOWER(city) LIKE ?', ["%{$location}%"])
                  ->orWhereRaw('LOWER(province) LIKE ?', ["%{$location}%"])
                  ->orWhereRaw('LOWER(address) LIKE ?', ["%{$location}%"]);
            });
        }

        // 3. Filter by Property Type (Extracted dynamically from property types)
        if ($request->filled('type')) {
            $type = strtolower(trim($request->input('type')));
            $query->whereRaw('LOWER(type) = ?', [$type]);
        }

        // 4. Filter by Bedrooms (Grouped: normal, middle, big)
        if ($request->filled('bedrooms')) {
            $bedrooms = $request->input('bedrooms');
            if ($bedrooms === 'normal') {
                $query->whereBetween('bedrooms', [1, 2]);
            } elseif ($bedrooms === 'middle') {
                $query->whereBetween('bedrooms', [3, 4]);
            } elseif ($bedrooms === 'big') {
                $query->where('bedrooms', '>=', 5);
            }
        }

        // 5. Filter by Rating (Human wording: biasa, bagus, bagus_banget)
        if ($request->filled('rating')) {
            $rating = $request->input('rating');
            if ($rating === 'biasa') {
                $query->whereBetween('rating', [3.0, 3.99]);
            } elseif ($rating === 'bagus') {
                $query->whereBetween('rating', [4.0, 4.69]);
            } elseif ($rating === 'bagus_banget') {
                $query->where('rating', '>=', 4.70);
            }
        }

        // 6. Filter by Price Range
        if ($request->filled('price')) {
            $priceRange = $request->input('price');
            if ($priceRange === 'low') {
                $query->where('price', '<', 5000000);
            } elseif ($priceRange === 'mid') {
                $query->whereBetween('price', [5000000, 10000000]);
            } elseif ($priceRange === 'high') {
                $query->where('price', '>', 10000000);
            }
        }

        // 7. Sorting
        if ($request->filled('sort')) {
            $sort = $request->input('sort');
            if ($sort === 'price_asc') {
                $query->orderBy('price', 'asc');
            } elseif ($sort === 'price_desc') {
                $query->orderBy('price', 'desc');
            } elseif ($sort === 'rating') {
                $query->orderBy('rating', 'desc');
            } else {
                $query->latest();
            }
        } else {
            $query->latest();
        }

        $properties = $query->paginate(9)->withQueryString();

        // 1. Extract dynamic locations from Destinations table and Properties city columns
        $destinationNames = Destination::where('status', true)->pluck('name')->toArray();
        $propertyCities = Properties::where('status', true)
            ->whereNotNull('city')
            ->where('city', '!=', '')
            ->distinct()
            ->pluck('city')
            ->toArray();

        $locations = array_unique(array_filter(array_merge($destinationNames, $propertyCities)));
        sort($locations);

        // 2. Extract dynamic property types from Properties table
        $propertyTypes = Properties::where('status', true)
            ->whereNotNull('type')
            ->where('type', '!=', '')
            ->distinct()
            ->pluck('type')
            ->toArray();
        sort($propertyTypes);

        // Prepare option arrays formatted for <x-ui.select2>
        $locationOptions = ['' => 'Semua Lokasi'];
        foreach ($locations as $loc) {
            $locationOptions[strtolower($loc)] = $loc;
        }

        $typeOptions = ['' => 'Semua Tipe'];
        foreach ($propertyTypes as $type) {
            $typeOptions[strtolower($type)] = $type;
        }

        $bedroomOptions = [
            '' => 'Semua Kamar',
            'normal' => 'Normal (1 - 2 Kamar)',
            'middle' => 'Middle (3 - 4 Kamar)',
            'big' => 'Big (5+ Kamar)',
        ];

        $ratingOptions = [
            '' => 'Semua Rating',
            'biasa' => '⭐️ Biasa (3.0 - 3.9)',
            'bagus' => '⭐️⭐️ Bagus (4.0 - 4.6)',
            'bagus_banget' => '⭐️⭐️⭐️ Bagus Banget (4.7+)',
        ];

        $priceOptions = [
            '' => 'Semua Harga',
            'low' => '< Rp 5.000.000 / malam',
            'mid' => 'Rp 5.000.000 - Rp 10.000.000 / malam',
            'high' => '> Rp 10.000.000 / malam',
        ];

        // Handle AJAX request
        if ($request->ajax() || $request->wantsJson()) {
            $gridHtml = view('villa.partials.grid', compact('properties'))->render();
            $paginationHtml = view('villa.partials.pagination', compact('properties'))->render();

            return response()->json([
                'success' => true,
                'html' => $gridHtml,
                'pagination' => $paginationHtml,
                'total' => $properties->total(),
            ]);
        }

        return view('villa.index', compact(
            'properties',
            'locationOptions',
            'typeOptions',
            'bedroomOptions',
            'ratingOptions',
            'priceOptions'
        ));
    }

    /**
     * Display public villa detail page.
     */
    public function show(Properties $property)
    {
        $property->load(['translations', 'settings', 'galleries', 'facilities.translations', 'approvedReviews.user', 'promotions']);
        $paymentMethods = PaymentMethod::where('is_active', true)->get();

        $approvedReviews = $property->approvedReviews;
        $totalReviews = $approvedReviews->count();
        $propRating = $property->rating > 0 ? number_format($property->rating, 1) : ($totalReviews > 0 ? number_format($approvedReviews->avg('rating'), 1) : '5.0');

        // Construct unified gallery list purely from database
        $galleryList = [];

        if ($property->main_image) {
            $mainImgUrl = Str::startsWith($property->main_image, ['http://', 'https://']) 
                ? $property->main_image 
                : asset('storage/' . $property->main_image);

            $galleryList[] = [
                'url' => $mainImgUrl,
                'title' => $property->name . ' - Utama'
            ];
        }

        if ($property->galleries && $property->galleries->count() > 0) {
            foreach ($property->galleries as $g) {
                $galleryList[] = [
                    'url' => Str::startsWith($g->image_path, ['http://', 'https://']) ? $g->image_path : asset('storage/' . $g->image_path),
                    'title' => $g->caption ?: $property->name
                ];
            }
        }

        $userReview = auth()->check() 
            ? $property->reviews()->where('user_id', auth()->id())->first() 
            : null;

        $userCanReview = auth()->check()
            ? \App\Models\Booking::where('property_id', $property->id)
                ->where('user_id', auth()->id())
                ->where('status', 'confirmed')
                ->exists()
            : false;

        $propertyRules = PropertyRule::active()
            ->with('translations')
            ->forPropertyType($property->type ?? 'Villa')
            ->orderBy('sort_order', 'asc')
            ->get();

        return view('villa.show', compact('property', 'paymentMethods', 'galleryList', 'approvedReviews', 'totalReviews', 'propRating', 'userReview', 'userCanReview', 'propertyRules'));
    }
}
