@extends('layouts.app')
@section('title', 'Yangi karta buyurtma qilish')
@section('content')
    <div class="max-w-lg mx-auto bg-white rounded-2xl shadow-xl p-8">
        <h2 class="text-3xl font-bold mb-6">Yangi karta</h2>
        <form method="POST" action="{{ route('dashboard.cards.store') }}">
            @csrf
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Karta turi</label>
                    <select name="type" class="w-full rounded-lg border-gray-300">
                        <option>Humo</option>
                        <option>Uzcard</option>
                        <option>Visa Classic</option>
                        <option>Visa Gold</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Yetkazib berish manzili</label>
                    <input type="text" name="address" placeholder="Toshkent sh., Chilanzar 45-uy" class="w-full rounded-lg border-gray-300">
                </div>
                <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-4 rounded-lg text-lg font-bold hover:from-indigo-700">
                    Buyurtma berish (bepul)
                </button>
            </div>
        </form>
    </div>
@endsection
