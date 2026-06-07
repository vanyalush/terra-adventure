@extends('layouts.app')

@section('content')

    <div class="admin-layout">

        <div class="admin-sidebar">
            <div class="admin-logo">Admin</div>
            <a href="/admin" class="admin-nav-item active">📋 Заявки</a>
            <a href="/admin/hikes" class="admin-nav-item">Походы</a>
            <a href="/admin/reviews" class="admin-nav-item">💬 Отзывы</a>
            <a href="/" class="admin-nav-item">← На сайт</a>
        </div>

        <div class="admin-main">

            @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif

            {{-- Заявки --}}
            <h2 class="admin-title">Заявки</h2>
            <div class="table-wrap">
                <table>
                    <thead>
                    <tr>
                        <th>Дата</th>
                        <th>Клиент</th>
                        <th>Поход</th>
                        <th>Сроки</th>
                        <th>Статус</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($bookings as $booking)
                        <tr>
                            <td>{{ $booking->created_at->format('d.m.Y H:i') }}</td>
                            <td>{{ $booking->last_name }} {{ $booking->first_name }}</td>
                            <td>{{ $booking->hikeDate->hike->name }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($booking->hikeDate->start_date)->format('d.m') }}
                                —
                                {{ \Carbon\Carbon::parse($booking->hikeDate->end_date)->format('d.m.Y') }}
                            </td>
                            <td>
                                @if($booking->status === 'new')
                                    <span class="badge badge-new">Новая</span>
                                @elseif($booking->status === 'confirmed')
                                    <span class="badge badge-ok">Подтверждена</span>
                                @else
                                    <span class="badge badge-cancel">Отменена</span>
                                @endif
                            </td>
                            <td>
                                @if($booking->status === 'new')
                                    <form method="POST" action="/admin/bookings/{{ $booking->id }}/confirm" style="display:inline">
                                        @csrf
                                        <button class="action-btn action-ok">✓</button>
                                    </form>
                                    <form method="POST" action="/admin/bookings/{{ $booking->id }}/cancel" style="display:inline">
                                        @csrf
                                        <button class="action-btn action-cancel">✗</button>
                                    </form>
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="text-align:center; color:#aaa">Заявок нет</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Отзывы на модерации --}}
            <h2 class="admin-title" id="reviews" style="margin-top:32px">Отзывы на модерации</h2>
            <div class="table-wrap">
                <table>
                    <thead>
                    <tr>
                        <th>Пользователь</th>
                        <th>Поход</th>
                        <th>Оценка</th>
                        <th>Текст</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($reviews as $review)
                        <tr>
                            <td>{{ $review->user->name }}</td>
                            <td>{{ $review->hike->name }}</td>
                            <td>{{ $review->rating }}/5</td>
                            <td style="max-width:300px; font-size:13px">{{ $review->text }}</td>
                            <td>
                                <form method="POST" action="/admin/reviews/{{ $review->id }}/approve" style="display:inline">
                                    @csrf
                                    <button class="action-btn action-ok">✓ Опубликовать</button>
                                </form>
                                <form method="POST" action="/admin/reviews/{{ $review->id }}/reject" style="display:inline">
                                    @csrf
                                    <button class="action-btn action-cancel">✗ Отклонить</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" style="text-align:center; color:#aaa">Нет отзывов на модерации</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection
