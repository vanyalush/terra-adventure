@extends('layouts.app')

@section('content')
    <div class="admin-layout">
        <div class="admin-sidebar">
            <div class="admin-logo">Admin</div>
            <a href="/admin" class="admin-nav-item">Заявки</a>
            <a href="/admin/hikes" class="admin-nav-item active">Походы</a>
            <a href="/admin/reviews" class="admin-nav-item">Отзывы</a>
            <a href="/" class="admin-nav-item">← На сайт</a>
        </div>
        <div class="admin-main">

            @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif

            {{-- Форма добавления --}}
            <div class="section-card" style="margin-bottom:24px">
                <h2 class="section-title">Добавить поход</h2>

                @if($errors->any())
                    <div class="alert-error" style="margin-bottom:16px">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.hikes.store') }}">
                    @csrf

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px">
                        <div class="form-row">
                            <label class="form-label">Название <span class="req">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-input {{ $errors->has('name') ? 'input-error' : '' }}" placeholder="Алтайский маршрут">
                        </div>
                        <div class="form-row">
                            <label class="form-label">Регион <span class="req">*</span></label>
                            <input type="text" name="region" value="{{ old('region') }}" class="form-input {{ $errors->has('region') ? 'input-error' : '' }}" placeholder="Алтай">
                        </div>
                        <div class="form-row">
                            <label class="form-label">Категория <span class="req">*</span></label>
                            <select name="category_id" class="form-input {{ $errors->has('category_id') ? 'input-error' : '' }}">
                                <option value="">— выберите —</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-row">
                            <label class="form-label">Маршрут <span class="req">*</span></label>
                            <input type="text" name="route" value="{{ old('route') }}" class="form-input {{ $errors->has('route') ? 'input-error' : '' }}" placeholder="Старт — Финиш">
                        </div>
                        <div class="form-row">
                            <label class="form-label">Расстояние (км) <span class="req">*</span></label>
                            <input type="number" name="distance_km" value="{{ old('distance_km') }}" class="form-input {{ $errors->has('distance_km') ? 'input-error' : '' }}" min="1">
                        </div>
                        <div class="form-row">
                            <label class="form-label">Длительность (дней) <span class="req">*</span></label>
                            <input type="number" name="duration_days" value="{{ old('duration_days') }}" class="form-input {{ $errors->has('duration_days') ? 'input-error' : '' }}" min="1">
                        </div>
                        <div class="form-row">
                            <label class="form-label">Мин. возраст <span class="req">*</span></label>
                            <input type="number" name="min_age" value="{{ old('min_age', 14) }}" class="form-input {{ $errors->has('min_age') ? 'input-error' : '' }}" min="1">
                        </div>
                        <div class="form-row">
                            <label class="form-label">Макс. участников <span class="req">*</span></label>
                            <input type="number" name="max_participants" value="{{ old('max_participants', 12) }}" class="form-input {{ $errors->has('max_participants') ? 'input-error' : '' }}" min="1">
                        </div>
                        <div class="form-row">
                            <label class="form-label">Сложность <span class="req">*</span></label>
                            <select name="difficulty" class="form-input {{ $errors->has('difficulty') ? 'input-error' : '' }}">
                                <option value="">— выберите —</option>
                                <option value="easy" {{ old('difficulty') === 'easy' ? 'selected' : '' }}>Лёгкая</option>
                                <option value="medium" {{ old('difficulty') === 'medium' ? 'selected' : '' }}>Средняя</option>
                                <option value="hard" {{ old('difficulty') === 'hard' ? 'selected' : '' }}>Высокая</option>
                            </select>
                        </div>
                        <div class="form-row">
                            <label class="form-label">Цена (₽) <span class="req">*</span></label>
                            <input type="number" name="price" value="{{ old('price') }}" class="form-input {{ $errors->has('price') ? 'input-error' : '' }}" min="0" placeholder="25000">
                        </div>
                    </div>

                    <div class="form-row">
                        <label class="form-label">Описание <span class="req">*</span></label>
                        <textarea name="description" rows="3" class="form-input {{ $errors->has('description') ? 'input-error' : '' }}" placeholder="Описание похода...">{{ old('description') }}</textarea>
                    </div>

                    <div style="display:flex; align-items:center; gap:16px; margin-top:4px">
                        <label style="display:flex; align-items:center; gap:6px; font-size:14px; cursor:pointer">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }}>
                            Активен (показывать на сайте)
                        </label>
                        <button type="submit" class="btn-primary">Добавить поход</button>
                    </div>
                </form>
            </div>

            {{-- Таблица --}}
            <h2 class="admin-title">Все походы</h2>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Название</th>
                            <th>Категория</th>
                            <th>Регион</th>
                            <th>Цена</th>
                            <th>Сложность</th>
                            <th>Статус</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hikes as $hike)
                            <tr>
                                <td>{{ $hike->name }}</td>
                                <td>{{ $hike->category->name }}</td>
                                <td>{{ $hike->region }}</td>
                                <td>{{ number_format($hike->price, 0, '.', ' ') }} ₽</td>
                                <td>
                                    @if($hike->difficulty === 'easy') Лёгкая
                                    @elseif($hike->difficulty === 'medium') Средняя
                                    @else Высокая
                                    @endif
                                </td>
                                <td>
                                    @if($hike->is_active)
                                        <span class="badge badge-ok">Активен</span>
                                    @else
                                        <span class="badge badge-cancel">Скрыт</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" style="text-align:center; color:#aaa; padding:24px">Походов нет</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
