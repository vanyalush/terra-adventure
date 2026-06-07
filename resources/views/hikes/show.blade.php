@extends('layouts.app')

@section('content')

    <div class="hike-page">

        <div class="hike-hero">
            <div class="hike-hero-content">
                <span class="hike-hero-cat">{{ $hike->category->name }}</span>
                <h1>{{ $hike->name }}</h1>
                <span class="hike-hero-region">{{ $hike->region }}</span>
            </div>
        </div>

        <div class="hike-detail">

            <div class="hike-detail-main">
                <h2>О походе</h2>
                <p>{{ $hike->description }}</p>

                <h2>Характеристики</h2>
                <div class="hike-chars">
                    <div class="hike-char">
                        <div class="char-label">Маршрут</div>
                        <div class="char-val">{{ $hike->route }}</div>
                    </div>
                    <div class="hike-char">
                        <div class="char-label">Расстояние</div>
                        <div class="char-val">{{ $hike->distance_km }} км</div>
                    </div>
                    <div class="hike-char">
                        <div class="char-label">Длительность</div>
                        <div class="char-val">{{ $hike->duration_days }} дней</div>
                    </div>
                    <div class="hike-char">
                        <div class="char-label">Возраст</div>
                        <div class="char-val">от {{ $hike->min_age }} лет</div>
                    </div>
                    <div class="hike-char">
                        <div class="char-label">Группа</div>
                        <div class="char-val">до {{ $hike->max_participants }} человек</div>
                    </div>
                    <div class="hike-char">
                        <div class="char-label">Сложность</div>
                        <div class="char-val">
                            @if($hike->difficulty === 'easy') Лёгкая
                            @elseif($hike->difficulty === 'medium') Средняя
                            @else Высокая
                            @endif
                        </div>
                    </div>
                </div>

                @if($hike->reviews->where('status', 'approved')->count() > 0)
                    <h2>Отзывы</h2>
                    @foreach($hike->reviews->where('status', 'approved') as $review)
                        <div class="review-card">
                            <div class="review-header">
                                <span class="review-author">{{ $review->user->name }}</span>
                                <span class="review-stars">{{ $review->rating }}/5</span>
                                <span class="review-date">{{ $review->created_at->format('d.m.Y') }}</span>
                            </div>
                            <p>{{ $review->text }}</p>
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="hike-detail-sidebar">
                <div class="hike-booking-box">
                    <div class="hike-booking-price">{{ number_format($hike->price, 0, '.', ' ') }} ₽</div>
                    <div class="hike-booking-hint">на одного участника</div>

                    @if($hike->dates->count() > 0)
                        <div class="hike-dates">
                            @foreach($hike->dates as $date)
                                <div class="hike-date {{ $date->spots_taken >= $date->spots_total ? 'full' : '' }}">
                                    <div>
                                        <div class="date-range">
                                            {{ \Carbon\Carbon::parse($date->start_date)->format('d.m') }}
                                            —
                                            {{ \Carbon\Carbon::parse($date->end_date)->format('d.m.Y') }}
                                        </div>
                                    </div>
                                    <div>
                                        @if($date->spots_taken >= $date->spots_total)
                                            <span class="spots-full">Мест нет</span>
                                        @else
                                            <span class="spots-free">{{ $date->spots_total - $date->spots_taken }} мест</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <a href="/booking/{{ $hike->id }}" class="btn-primary btn-block">Подать заявку</a>
                </div>
            </div>

        </div>

    </div>

@endsection
