@extends('layouts.app')

@section('content')

    <div class="booking-page">

        <a href="/hikes/{{ $hike->id }}" class="back-link">← {{ $hike->name }}</a>
        <h1>Запись в поход</h1>

        @if($errors->any())
            <div class="alert-error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('booking.store', $hike) }}" id="booking-form">
            @csrf

            {{-- Выбор даты --}}
            <div class="form-section date-section">
                <h2>Выберите дату</h2>
                @forelse($hike->dates as $date)
                    @php $full = $date->spots_taken >= $date->spots_total; @endphp
                    <label class="date-option {{ $full ? 'disabled' : '' }}">
                        <input type="radio" name="hike_date_id" value="{{ $date->id }}"
                            {{ $full ? 'disabled' : '' }}
                            {{ old('hike_date_id') == $date->id ? 'checked' : '' }}>
                        <div class="date-option-body">
                            <div class="date-range">
                                {{ \Carbon\Carbon::parse($date->start_date)->format('d.m') }}
                                —
                                {{ \Carbon\Carbon::parse($date->end_date)->format('d.m.Y') }}
                            </div>
                            <div>
                                @if($full)
                                    <span class="spots-full">Мест нет</span>
                                @else
                                    <span class="spots-free">{{ $date->spots_total - $date->spots_taken }} мест</span>
                                @endif
                            </div>
                        </div>
                    </label>
                @empty
                    <p style="color:#888">Ближайших дат нет</p>
                @endforelse
            </div>

            {{-- Данные участника --}}
            <div class="form-section">
                <h2>Данные участника</h2>

                <div class="form-row">
                    <label class="form-label">Фамилия <span class="req">*</span></label>
                    <input type="text" name="last_name" value="{{ old('last_name', auth()->user()?->last_name) }}"
                           placeholder="Иванов" class="form-input {{ $errors->has('last_name') ? 'input-error' : '' }}">
                    @error('last_name') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-row">
                    <label class="form-label">Имя <span class="req">*</span></label>
                    <input type="text" name="first_name" value="{{ old('first_name', auth()->user()?->name) }}"
                           placeholder="Иван" class="form-input {{ $errors->has('first_name') ? 'input-error' : '' }}">
                    @error('first_name') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-row">
                    <label class="form-label">Отчество</label>
                    <input type="text" name="middle_name" value="{{ old('middle_name', auth()->user()?->middle_name) }}"
                           placeholder="Иванович" class="form-input">
                </div>

                <div class="form-row">
                    <label class="form-label">Дата рождения <span class="req">*</span></label>
                    <input type="date" name="birth_date" value="{{ old('birth_date') }}"
                           class="form-input {{ $errors->has('birth_date') ? 'input-error' : '' }}">
                    @error('birth_date') <div class="field-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Отправить заявку</button>
                <a href="/hikes/{{ $hike->id }}" class="btn-cancel">Отмена</a>
            </div>

        </form>

    </div>

@endsection
