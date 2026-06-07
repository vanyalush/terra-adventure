@extends('layouts.app')

@section('content')
<div class="page-container">
    <div class="page-header">
        <h1>Где нас найти</h1>
    </div>

    <div class="location-layout">
        <div class="section-card">
            <h2 class="section-title">Контакты</h2>

            <div class="contact-list">
                <div class="contact-item">
                    <div>
                        <div class="contact-label">Адрес</div>
                        <div class="contact-value">г. Ижевск, ул. Холмогорова, д. 24</div>
                    </div>
                </div>
                <div class="contact-item">
                    <div>
                        <div class="contact-label">Телефон</div>
                        <a href="tel:+74951234567" class="contact-value contact-link">+7 (912) 123-45-67</a>
                    </div>
                </div>
                <div class="contact-item">
                    <div>
                        <div class="contact-label">Email</div>
                        <a href="mailto:info@terra-adventure.ru" class="contact-value contact-link">info@terra-adventure.ru</a>
                    </div>
                </div>
                <div class="contact-item">
                    <div>
                        <div class="contact-label">Режим работы</div>
                        <div class="contact-value">Пн–Пт: 10:00 – 19:00</div>
                        <div class="contact-value">Сб: 11:00 – 16:00</div>
                        <div class="contact-value" style="color:#aaa">Вс: выходной</div>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection
