@extends('layouts.app')
@section('title', 'Yordam so'rash')
@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-xl p-8">
    <h2 class="text-3xl font-bold mb-6">Texnik yordam</h2>
    <form method="POST" action="{{ route('dashboard.support.store') }}">
        @csrf
        <div class="space-y-6">
            <select name="category" class="w-full rounded-lg border-gray-300">
                <option>Karta bilan bog'liq</option>
                <option>O'tkazma muammosi</option>
                <option>Ilovada xato</option>
                <option>Boshqa</option>
            </select>
            <input type="text" name="subject" placeholder="Mavzu" class="w-full rounded-lg border-gray-300" required>
            <textarea name="message" rows="8" placeholder="Muammoingizni batafsil yozing..." class="w-full rounded-lg border-gray-300" required></textarea>
            <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-lg font-bold hover:bg-blue-700">
                Yuborish
            </button>
        </div>
    </form>
</div>
@endsection
