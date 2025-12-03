@extends('layouts.app')
@section('title', 'Yangi hisob ochish')
@section('content')
    <div class="max-w-md mx-auto bg-white rounded-2xl shadow-xl p-8">
        <h2 class="text-3xl font-bold mb-6">Yangi hisob ochish</h2>
        <form method="POST" action="{{ route('dashboard.accounts.store') }}">
            @csrf
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Hisob nomi</label>
                <input type="text" name="name" placeholder="Masalan: Asosiy hisob" class="w-full rounded-lg border-gray-300">
            </div>
            <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 font-semibold">Hisob ochish</button>
        </form>
    </div>
@endsection
