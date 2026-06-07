@extends('layouts.app')

@section('content')

    <div class="catalog-page">

        <div class="catalog-filters">
            <a href="/catalog" class="{{ !request('category') ? 'active' : '' }}">Все</a>
            @foreach($categories as $cat)
                <a href="/catalog?category={{ $cat->id }}"
                   class="{{ request('category') == $cat->id ? 'active' : '' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>

        <div class="catalog-sort">
            <span>Сортировка:</span>
            <a href="/catalog?{{ http_build_query(array_merge(request()->all(), ['sort' => 'price'])) }}"
               class="{{ request('sort') === 'price' ? 'active' : '' }}">По цене</a>
            <a href="/catalog?{{ http_build_query(array_merge(request()->all(), ['sort' => 'duration'])) }}"
               class="{{ request('sort') === 'duration' ? 'active' : '' }}">По длительности</a>
            <a href="/catalog?{{ http_build_query(array_merge(request()->all(), ['sort' => 'difficulty'])) }}"
               class="{{ request('sort') === 'difficulty' ? 'active' : '' }}">По сложности</a>
        </div>

        <div class="catalog-grid">
            @forelse($hikes as $hike)
                <div class="hike-card">
                    <div class="hike-card-badge">{{ $hike->category->name }}</div>
                    <div class="hike-card-body">
                        <h3>{{ $hike->name }}</h3>
                        <div class="hike-meta">
                            <span>{{ $hike->duration_days }} дней</span>
                            <span>{{ $hike->region }}</span>
                            <span>до {{ $hike->max_participants }} чел.</span>
                            <span>
                                @if($hike->difficulty === 'easy') Лёгкая
                                @elseif($hike->difficulty === 'medium') Средняя
                                @else Высокая
                                @endif
                            </span>
                        </div>
                        <div class="hike-card-footer">
                            <span class="hike-price">{{ number_format($hike->price, 0, '.', ' ') }} ₽</span>
                            <a href="/hikes/{{ $hike->id }}" class="btn-primary">Подробнее</a>
                        </div>
                    </div>
                </div>
            @empty
                <p>Походов не найдено</p>
            @endforelse
        </div>

    </div>

@endsection
