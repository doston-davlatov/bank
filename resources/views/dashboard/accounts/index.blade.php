@extends('layouts.app')
@section('title', 'Mening hisoblarim')
@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold">Mening hisoblarim</h2>
        <a href="{{ route('dashboard.accounts.create') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700">+ Yangi hisob</a>
    </div>

    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @forelse($accounts ?? [] as $account)
            <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition">
                <h3 class="text-xl font-bold">{{ $account->name ?? 'Asosiy hisob' }}</h3>
                <p class="text-gray-500 text-sm">№ {{ $account->account_number ?? '1234567890' }}</p>
                <p class="text-3xl font-bold text-green-600 mt-4">{{ number_format($account->balance ?? 0) }} so'm</p>
                <div class="mt-6 flex gap-3">
                    <a href="{{ route('dashboard.accounts.show', $account) }}" class="text-blue-600 hover:underline">Batafsil</a>
                    <a href="{{ route('dashboard.accounts.transactions', $account) }}" class="text-indigo-600 hover:underline">Tranzaksiyalar</a>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12 bg-white rounded-xl">
                <p class="text-xl text-gray-500">Hozircha hech qanday hisob yo'q</p>
                <a href="{{ route('dashboard.accounts.create') }}" class="text-blue-600 hover:underline">Birinchi hisobni oching →</a>
            </div>
        @endforelse
    </div>
@endsection
