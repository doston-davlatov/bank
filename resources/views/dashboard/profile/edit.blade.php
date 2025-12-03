@extends('layouts.app')
@section('title', 'Profilni tahrirlash')
@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <h2 class="text-3xl font-bold mb-6">Profilni tahrirlash</h2>
            <form method="POST" action="{{ route('dashboard.profile.update') }}">
                @csrf @method('PATCH')
                <div class="grid gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Ism</label>
                        <input type="text" name="name" value="{{ auth()->user()->name }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ auth()->user()->email }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
                    </div>
                    <div class="flex gap-4">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">Saqlash</button>
                        <a href="{{ route('dashboard.index') }}" class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-400">Bekor qilish</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
