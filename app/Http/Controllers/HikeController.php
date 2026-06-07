<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Hike;
use Illuminate\Http\Request;

class HikeController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        $hikes = Hike::with('category')
            ->where('is_active', true)
            ->when(request('category'), fn($q) =>
            $q->where('category_id', request('category'))
            )
            ->when(request('sort') === 'price', fn($q) =>
            $q->orderBy('price')
            )
            ->when(request('sort') === 'duration', fn($q) =>
            $q->orderBy('duration_days')
            )
            ->when(request('sort') === 'difficulty', fn($q) =>
            $q->orderBy('difficulty')
            )
            ->orderBy('created_at', 'desc')
            ->get();

        return view('catalog.index', compact('hikes', 'categories'));
    }

    public function show(Hike $hike)
    {
        $hike->load('category', 'dates', 'reviews');
        return view('hikes.show', compact('hike'));
    }
}
