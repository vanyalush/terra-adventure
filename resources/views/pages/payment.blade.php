@extends('layouts.app')

@section('content')
<div class="page-container">
    <div class="page-header">
        <h1>Условия оплаты</h1>
    </div>

    <div class="section-card">
        <h2 class="section-title">Способы оплаты</h2>
        <div class="info-grid">
            <div class="info-item">
                <div>
                    <div class="info-title">Банковская карта</div>
                    <p class="info-text">Оплата онлайн через защищённую форму. Принимаем Visa, Mastercard, МИР.</p>
                </div>
            </div>
            <div class="info-item">
                <div>
                    <div class="info-title">Банковский перевод</div>
                    <p class="info-text">Перевод на расчётный счёт организации. Реквизиты высылаем после подтверждения заявки.</p>
                </div>
            </div>
            <div class="info-item">
                <div>
                    <div class="info-title">Наличные</div>
                    <p class="info-text">Оплата наличными в нашем офисе или при встрече с инструктором в день отправления.</p>
                </div>
            </div>
            <div class="info-item">
                <div>
                    <div class="info-title">СБП / Перевод по телефону</div>
                    <p class="info-text">Быстрый перевод по номеру телефона через Систему быстрых платежей.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
