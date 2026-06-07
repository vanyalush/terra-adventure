@extends('layouts.app')

@section('content')
    <div class="admin-layout">
        <div class="admin-sidebar">
            <div class="admin-logo">Admin</div>
            <a href="/admin" class="admin-nav-item">📋 Заявки</a>
            <a href="/admin/hikes" class="admin-nav-item">Походы</a>
            <a href="/admin/reviews" class="admin-nav-item active">💬 Отзывы</a>
            <a href="/" class="admin-nav-item">← На сайт</a>
        </div>
        <div class="admin-main">
            <h2 class="admin-title">Все отзывы</h2>
            <div class="table-wrap">
                <table>
                    <thead>
                    <tr>
                        <th>Пользователь</th>
                        <th>Поход</th>
                        <th>Оценка</th>
                        <th>Текст</th>
                        <th>Статус</th>
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
                                @if($review->status === 'pending')
                                    <span class="badge badge-new">На модерации</span>
                                @elseif($review->status === 'approved')
                                    <span class="badge badge-ok">Опубликован</span>
                                @else
                                    <span class="badge badge-cancel">Отклонён</span>
                                @endif
                            </td>
                            <td>
                                @if($review->status === 'pending')
                                    <form method="POST" action="/admin/reviews/{{ $review->id }}/approve" style="display:inline">
                                        @csrf
                                        <button class="action-btn action-ok">✓</button>
                                    </form>
                                    <form method="POST" action="/admin/reviews/{{ $review->id }}/reject" style="display:inline">
                                        @csrf
                                        <button class="action-btn action-cancel">✗</button>
                                    </form>
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="text-align:center; color:#aaa">Отзывов нет</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
