<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CabinetController extends Controller
{
    public function index(): View
    {
        $bookings = Booking::with(['hikeDate.hike'])
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();

        return view('cabinet.index', compact('bookings'));
    }

    public function cancel(Booking $booking): RedirectResponse
    {
        abort_if($booking->user_id !== auth()->id(), 403);
        abort_if($booking->status === 'cancelled', 422);

        $booking->update(['status' => 'cancelled']);
        $booking->hikeDate()->decrement('spots_taken');

        return redirect()->route('cabinet.index')->with('success', 'Заявка отменена.');
    }
}
