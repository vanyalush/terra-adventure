@extends('layouts.app')

@section('content')
<div class="page-container">
    <div class="page-header">
        <h1>Личный кабинет</h1>
        <p class="page-subtitle">{{ auth()->user()->last_name }} {{ auth()->user()->name }} {{ auth()->user()->middle_name }}</p>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="section-card">
        <h2 class="section-title">Мои заявки</h2>

        @if($bookings->isEmpty())
            <div class="empty-state">
                <p>У вас пока нет заявок</p>
                <a href="{{ route('catalog') }}" class="btn-primary">Перейти в каталог</a>
            </div>
        @else
            <div class="bookings-list">
                @foreach($bookings as $booking)
                    <div class="booking-item">
                        <div class="booking-info">
                            <div class="booking-hike">{{ $booking->hikeDate->hike->name }}</div>
                            <div class="booking-dates">
                                {{ \Carbon\Carbon::parse($booking->hikeDate->start_date)->format('d.m.Y') }}
                                —
                                {{ \Carbon\Carbon::parse($booking->hikeDate->end_date)->format('d.m.Y') }}
                            </div>
                            <div class="booking-participant">
                                {{ $booking->last_name }} {{ $booking->first_name }} {{ $booking->middle_name }}
                            </div>
                        </div>
                        <div class="booking-right">
                            @if($booking->status === 'new')
                                <span class="badge badge-new">Новая</span>
                            @elseif($booking->status === 'confirmed')
                                <span class="badge badge-ok">Подтверждена</span>
                            @else
                                <span class="badge badge-cancel">Отменена</span>
                            @endif

                            @if($booking->status !== 'cancelled')
                                <form method="POST" action="{{ route('cabinet.cancel', $booking) }}" class="mt-2"
                                      onsubmit="return confirm('Отменить заявку?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-link-danger">Отменить</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
