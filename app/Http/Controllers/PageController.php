<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Hike;
use App\Models\Review;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        $hikesCount = Hike::where('is_active', true)->count();
        $bookingsCount = Booking::where('status', 'confirmed')->count();
        $reviews = Review::with('user', 'hike')
            ->where('status', 'approved')
            ->inRandomOrder()
            ->limit(5)
            ->get();

        return view('home', compact('hikesCount', 'bookingsCount', 'reviews'));
    }
}
