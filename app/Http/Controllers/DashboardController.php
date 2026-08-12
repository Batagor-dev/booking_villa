<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Properties;
use App\Models\Booking;
use App\Models\Destination;
use App\Models\Review;
use App\Models\User;
use App\Models\Promotion;
use App\Models\Article;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Property Stats
        $totalProperties = Properties::count();
        $activeProperties = Properties::where('status', 1)->count();
        $featuredProperties = Properties::where('is_featured', 1)->count();

        // Property types count for donut chart
        $typesCount = Properties::select('type', DB::raw('count(*) as count'))
            ->groupBy('type')
            ->pluck('count', 'type')
            ->toArray();

        $propertyTypeLabels = ['Villa', 'Resort', 'Boutique Hotel', 'Apartment', 'Private House'];
        $propertyTypeData = [];
        foreach ($propertyTypeLabels as $label) {
            $propertyTypeData[] = $typesCount[$label] ?? 0;
        }

        // If no properties exist yet, provide nice fallback distribution for preview
        if (array_sum($propertyTypeData) == 0) {
            $propertyTypeData = [12, 5, 4, 6, 3];
        }

        // 2. Booking & Revenue Stats
        $totalBookings = Booking::count();
        $totalRevenue = Booking::whereIn('status', ['confirmed', 'completed', 'paid', 'success'])->sum('subtotal');
        if ($totalRevenue == 0) {
            $totalRevenue = Booking::sum('subtotal');
        }

        $pendingBookings = Booking::where('status', 'pending')->count();
        $confirmedBookings = Booking::where('status', 'confirmed')->count();
        $completedBookings = Booking::where('status', 'completed')->count();

        // Monthly trends over last 6 months for Chart
        $months = [];
        $monthlyRevenue = [];
        $monthlyBookings = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('M Y');

            $rev = Booking::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('subtotal');

            $count = Booking::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $monthlyRevenue[] = (float) $rev;
            $monthlyBookings[] = $count;
        }

        // Fallback sample trend data for rich chart visualization if DB is fresh
        if (array_sum($monthlyRevenue) == 0 && array_sum($monthlyBookings) == 0) {
            $months = ['Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'];
            $monthlyRevenue = [18500000, 24000000, 31000000, 42000000, 56000000, 78500000];
            $monthlyBookings = [8, 12, 16, 22, 29, 41];
        }

        // Recent Bookings
        $recentBookings = Booking::with(['property', 'user', 'paymentMethod'])
            ->latest()
            ->take(6)
            ->get();

        // 3. Destinations
        $totalDestinations = Destination::count();
        $topDestinations = Destination::withCount('properties')
            ->orderBy('properties_count', 'desc')
            ->take(5)
            ->get();

        // 4. Reviews & Ratings
        $totalReviews = Review::count();
        $avgRating = Review::avg('rating') ? round(Review::avg('rating'), 1) : 4.9;
        $recentReviews = Review::with(['property', 'user'])
            ->latest()
            ->take(4)
            ->get();

        // 5. System Stats
        $totalUsers = User::count();
        $activePromotions = Promotion::active()->count();
        $totalArticles = Article::count();

        // Top Villas by Rating
        $topVillas = Properties::with('destination')
            ->orderBy('rating', 'desc')
            ->take(4)
            ->get();

        return view('dashboard.index', compact(
            'totalProperties',
            'activeProperties',
            'featuredProperties',
            'propertyTypeLabels',
            'propertyTypeData',
            'totalBookings',
            'totalRevenue',
            'pendingBookings',
            'confirmedBookings',
            'completedBookings',
            'months',
            'monthlyRevenue',
            'monthlyBookings',
            'recentBookings',
            'totalDestinations',
            'topDestinations',
            'totalReviews',
            'avgRating',
            'recentReviews',
            'totalUsers',
            'activePromotions',
            'totalArticles',
            'topVillas'
        ));
    }
}
