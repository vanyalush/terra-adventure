@extends('layouts.app')

@section('content')

    {{-- Hero --}}
    <div class="home-hero">
        <h1>Открой мир походов с Terra Adventure</h1>
        <p>Пешие, лыжные, конные и водные маршруты по всей России</p>
        <div class="hero-btns">
            <a href="/catalog" class="btn-primary">Смотреть каталог</a>
        </div>
    </div>

    {{-- Статистика --}}
    <div class="home-stats">
        <div class="stat-card">
            <div class="stat-val">{{ $hikesCount }}</div>
            <div class="stat-label">Маршрутов</div>
        </div>
        <div class="stat-card">
            <div class="stat-val">{{ $bookingsCount }}+</div>
            <div class="stat-label">Участников</div>
        </div>
        <div class="stat-card">
            <div class="stat-val">4</div>
            <div class="stat-label">Категории</div>
        </div>
        <div class="stat-card">
            <div class="stat-val">{{ $reviews->count() }}</div>
            <div class="stat-label">Отзывов</div>
        </div>
    </div>

    {{-- О нас --}}
    <div class="home-about" id="about">
        <div class="about-logo">
            <div class="about-tagline">«Природа зовёт — мы ведём»</div>
            <p>Мы организуем походы с 2018 года. Наши инструкторы — опытные гиды, влюблённые в природу России.</p>
        </div>

        {{-- Отзывы --}}
        <div class="reviews-block">
            <h2>Отзывы клиентов</h2>

            @if($reviews->count() > 0)
                <div class="reviews-slider">
                    @foreach($reviews as $index => $review)
                        <div class="review-slide {{ $index === 0 ? 'active' : '' }}">
                            <div class="review-card">
                                <div class="review-header">
                                    <div class="review-avatar">
                                        {{ mb_strtoupper(mb_substr($review->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="review-author">{{ $review->user->name }}</div>
                                        <div class="review-date">{{ $review->created_at->format('d.m.Y') }}</div>
                                    </div>
                                    <div class="review-stars" style="margin-left:auto">
                                        {{ $review->rating }}/5
                                    </div>
                                </div>
                                <p>{{ $review->text }}</p>
                                <div class="review-hike">{{ $review->hike->name }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="slider-dots">
                    @foreach($reviews as $index => $review)
                        <button class="dot {{ $index === 0 ? 'active' : '' }}" onclick="goToSlide({{ $index }})"></button>
                    @endforeach
                </div>
            @else
                <p style="color:#888">Отзывов пока нет</p>
            @endif
        </div>
    </div>

    <script>
        function goToSlide(index) {
            document.querySelectorAll('.review-slide').forEach((s, i) => {
                s.classList.toggle('active', i === index);
            });
            document.querySelectorAll('.dot').forEach((d, i) => {
                d.classList.toggle('active', i === index);
            });
        }

        // Авто-слайдер
        let current = 0;
        const total = {{ $reviews->count() }};
        setInterval(() => {
            if (total > 0) {
                current = (current + 1) % total;
                goToSlide(current);
            }
        }, 4000);
    </script>

@endsection
