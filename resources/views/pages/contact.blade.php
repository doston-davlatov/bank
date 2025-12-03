@extends('layouts.app')
@section('title', 'Aloqa')
@section('content')
    <div class="bg-white rounded-2xl shadow-xl p-8 max-w-4xl mx-auto">
        <h1 class="text-4xl font-bold text-gray-800 mb-6">Biz bilan bog'laning</h1>
        <div class="grid md:grid-cols-2 gap-8">
            <div>
                <h3 class="text-2xl font-semibold mb-4">Kontakt ma'lumotlari</h3>
                <p class="text-lg text-gray-600 mb-3">Telefon: <strong>+998 71 200-00-00</strong></p>
                <p class="text-lg text-gray-600 mb-3">Email: <strong>support@mybank.uz</strong></p>
                <p class="text-lg text-gray-600 mb-3">Manzil: Toshkent sh., Amir Temur ko'chasi 100A</p>
            </div>
            <div>
                <h3 class="text-2xl font-semibold mb-4">Ish vaqti</h3>
                <p class="text-gray-600">Dushanba - Juma: 09:00 - 18:00</p>
                <p class="text-gray-600">Shanba: 10:00 - 15:00</p>
                <p class="text-gray-600">Yakshanba: dam olish kuni</p>
            </div>
        </div>
    </div>
@endsection
