<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Hike;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('user', 'hikeDate.hike')
            ->orderBy('created_at', 'desc')
            ->get();

        $hikes = Hike::with('category')->get();

        $reviews = Review::with('user', 'hike')
            ->where('status', 'pending')
            ->get();

        return view('admin.index', compact('bookings', 'hikes', 'reviews'));
    }

    public function confirmBooking(Booking $booking)
    {
        $booking->update(['status' => 'confirmed']);
        return back()->with('success', 'Заявка подтверждена');
    }

    public function cancelBooking(Booking $booking)
    {
        $booking->update(['status' => 'cancelled']);
        return back()->with('success', 'Заявка отменена');
    }

    public function approveReview(Review $review)
    {
        $review->update(['status' => 'approved']);
        return back()->with('success', 'Отзыв опубликован');
    }

    public function rejectReview(Review $review)
    {
        $review->update(['status' => 'rejected']);
        return back()->with('success', 'Отзыв отклонён');
    }
    public function hikes()
    {
        $hikes = Hike::with('category')->orderByDesc('id')->get();
        $categories = Category::orderBy('name')->get();

        return view('admin.hikes', compact('hikes', 'categories'));
    }

    public function storeHike(Request $request): RedirectResponse
    {
        $request->validate([
            'category_id'     => 'required|exists:categories,id',
            'name'            => 'required|string|max:255',
            'region'          => 'required|string|max:255',
            'route'           => 'required|string|max:255',
            'description'     => 'required|string',
            'distance_km'     => 'required|numeric|min:1',
            'duration_days'   => 'required|integer|min:1',
            'min_age'         => 'required|integer|min:1',
            'max_participants' => 'required|integer|min:1',
            'difficulty'      => 'required|in:easy,medium,hard',
            'price'           => 'required|numeric|min:0',
        ], [
            'category_id.required'      => 'Выберите категорию',
            'name.required'             => 'Введите название',
            'region.required'           => 'Введите регион',
            'route.required'            => 'Введите маршрут',
            'description.required'      => 'Введите описание',
            'distance_km.required'      => 'Введите расстояние',
            'duration_days.required'    => 'Введите длительность',
            'min_age.required'          => 'Введите минимальный возраст',
            'max_participants.required' => 'Введите макс. участников',
            'difficulty.required'       => 'Выберите сложность',
            'price.required'            => 'Введите цену',
        ]);

        Hike::create([
            'category_id'      => $request->category_id,
            'name'             => $request->name,
            'region'           => $request->region,
            'route'            => $request->route,
            'description'      => $request->description,
            'distance_km'      => $request->distance_km,
            'duration_days'    => $request->duration_days,
            'min_age'          => $request->min_age,
            'max_participants' => $request->max_participants,
            'difficulty'       => $request->difficulty,
            'price'            => $request->price,
            'is_active'        => $request->has('is_active'),
        ]);

        return redirect()->route('admin.hikes')->with('success', 'Поход добавлен');
    }

    public function reviews()
    {
        $reviews = Review::with('user', 'hike')->get();
        return view('admin.reviews', compact('reviews'));
    }
}
