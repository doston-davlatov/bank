@extends('layouts.app')
@section('title', 'Mening kartalarim')
@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold">Mening kartalarim</h2>
        <a href="{{ route('dashboard.cards.create') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700">
            + Yangi karta
        </a>
    </div>

    <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
        @forelse($cards ?? [] as $card)
            <div class="relative bg-gradient-to-br from-gray-800 to-black text-white rounded-2xl p-8 shadow-2xl overflow-hidden">
                <div class="absolute top-4 right-4 text-4xl opacity-20">VISA</div>
                <div class="flex justify-between items-start mb-8">
                    <div class="bg-yellow-400 w-12 h-8 rounded"></div>
                    <span class="text-sm">{{ $card->type ?? 'Debit' }}</span>
                </div>
                <p class="text-2xl tracking-wider mb-8">8600 {{ substr($card->number ?? '1234567890123456', -12) }}</p>
                <div class="flex justify-between">
                    <div>
                        <p class="text-xs opacity-75">Amal qilish muddati</p>
                        <p class="text-lg">{{ $card->expiry ?? '12/27' }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs opacity-75">Balans</p>
                        <p class="text-2xl font-bold">{{ number_format($card->balance ?? 8450000) }} so'm</p>
                    </div>
                </div>
                <div class="mt-6 flex gap-3">
                    <form method="POST" action="{{ route('dashboard.cards.block', $card) }}" class="inline">
                        @csrf @method('POST')
                        <button class="text-xs bg-red-600 px-4 py-2 rounded hover:bg-red-700">Bloklash</button>
                    </form>
                    <form method="POST" action="{{ route('dashboard.cards.set-limit', $card) }}" class="inline">
                        @csrf @method('POST')
                        <button class="text-xs bg-blue-600 px-4 py-2 rounded hover:bg-blue-700">Limit o'rnatish</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-16 bg-white rounded-xl shadow">
                <p class="text-2xl text-gray-500 mb-4">Sizda hali karta yo'q</p>
                <a href="{{ route('dashboard.cards.create') }}" class="text-indigo-600 text-lg hover:underline">Birinchi kartangizni buyurtma qiling →</a>
            </div>
        @endforelse
    </div>
@endsection
