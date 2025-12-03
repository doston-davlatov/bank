@extends('layouts.app')
@section('title', 'Hisob tafsilotlari')
@section('content')
    <div class="bg-white rounded-2xl shadow-xl p-8 max-w-4xl mx-auto">
        <h2 class="text-3xl font-bold mb-6">Hisob tafsilotlari</h2>
        <div class="grid md:grid-cols-2 gap-8">
            <div>
                <p class="text-gray-500">Hisob raqami</p>
                <p class="text-2xl font-bold">{{ $account->account_number ?? '1234567890' }}</p>
            </div>
            <div>
                <p class="text-gray-500">Joriy balans</p>
                <p class="text-3xl font-bold text-green-600">{{ number_format($account->balance ?? 0) }} so'm</p>
            </div>
        </div>
        <div class="mt-8 flex gap-4">
            <a href="{{ route('dashboard.transfer.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg">Pul o'tkazish</a>
            <a href="{{ route('dashboard.accounts.transactions', $account) }}" class="bg-indigo-600 text-white px-6 py-3 rounded-lg">Tranzaksiyalar</a>
        </div>
    </div>
@endsection
