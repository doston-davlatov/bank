@extends('layouts.app')
@section('title', 'Doimiy qabul qiluvchilar')
@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold">Doimiy qabul qiluvchilar</h2>
        <a href="{{ route('dashboard.beneficiaries.create') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg">+ Qo'shish</a>
    </div>

    <div class="grid gap-6">
        @forelse($beneficiaries ?? [] as $b)
            <div class="bg-white rounded-xl shadow p-6 flex justify-between items-center hover:shadow-lg transition">
                <div>
                    <h3 class="text-xl font-bold">{{ $b->name }}</h3>
                    <p class="text-gray-600">{{ $b->card_number ?? $b->account_number }}</p>
                    <p class="text-sm text-gray-500">{{ $b->bank ?? 'MyBank' }}</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('dashboard.transfer.create') }}?to={{ $b->card_number }}" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">O'tkazish</a>
                    <a href="{{ route('dashboard.beneficiaries.edit', $b) }}" class="text-gray-600 hover:text-gray-900">Tahrirlash</a>
                </div>
            </div>
        @empty
            <div class="text-center py-16 bg-white rounded-xl">
                <p class="text-xl text-gray-500">Doimiy qabul qiluvchilar yo'q</p>
            </div>
        @endforelse
    </div>
@endsection
