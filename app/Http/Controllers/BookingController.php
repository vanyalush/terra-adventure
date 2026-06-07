<?php

namespace App\Http\Controllers;

use App\Models\Hike;
use App\Models\Booking;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function create(Hike $hike): View
    {
        $hike->load('dates');
        return view('booking.create', compact('hike'));
    }

    public function store(Request $request, Hike $hike): JsonResponse|RedirectResponse
    {
        $request->validate([
            'hike_date_id' => 'required|exists:hike_dates,id',
            'last_name'    => 'required|string|max:100',
            'first_name'   => 'required|string|max:100',
            'middle_name'  => 'nullable|string|max:100',
            'birth_date'   => 'required|date',
        ], [
            'hike_date_id.required' => 'Выберите дату похода',
            'last_name.required'    => 'Введите фамилию',
            'first_name.required'   => 'Введите имя',
            'birth_date.required'   => 'Введите дату рождения',
            'birth_date.date'       => 'Неверный формат даты',
        ]);

        Booking::create([
            'user_id'      => auth()->id(),
            'hike_date_id' => $request->hike_date_id,
            'last_name'    => $request->last_name,
            'first_name'   => $request->first_name,
            'middle_name'  => $request->middle_name,
            'birth_date'   => $request->birth_date,
            'status'       => 'new',
        ]);

        // Увеличиваем счётчик занятых мест
        $date = \App\Models\HikeDate::find($request->hike_date_id);
        $date->increment('spots_taken');

        if ($request->expectsJson()) {
            return response()->json(['redirect' => route('cabinet.index')]);
        }

        return redirect()->route('cabinet.index')->with('success', 'Заявка успешно отправлена!');
    }
}
