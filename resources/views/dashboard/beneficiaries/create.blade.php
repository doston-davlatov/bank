@extends('layouts.app')
@section('title', 'Yangi qabul qiluvchi qo\'shish')
@section('content')
    <div class="max-w-lg mx-auto bg-white rounded-2xl shadow-xl p-8">
        <h2 class="text-3xl font-bold mb-6">Doimiy qabul qiluvchi</h2>
        <form method="POST" action="{{ route('dashboard.beneficiaries.store') }}">
            @csrf
            <div class="space-y-6">
                <input type="text" name="name" placeholder="Ismi (masalan: Do'stim Ahmad)" class="w-full rounded-lg border-gray-300" required>
                <input type="text" name="card_number" placeholder="Karta raqami: 8600 1234 5678 9012" class="w-full rounded-lg border-gray-300" required>
                <input type="text" name="bank" placeholder="Bank nomi (ixtiyoriy)" class="w-full rounded-lg border-gray-300">
                <button type="submit" class="w-full bg-green-600 text-white py-4 rounded-lg font-bold hover:bg-green-700">
                    Saqlash
                </button>
            </div>
        </form>
    </div>
@endsection
