@extends('layouts.app')
@section('title', 'Xavfsizlik')
@section('content')
    <div class="max-w-4xl mx-auto space-y-8">
        <h2 class="text-3xl font-bold">Xavfsizlik sozlamalari</h2>

        <div class="bg-white rounded-xl shadow p-8">
            <h3 class="text-xl font-bold mb-4">Ikki bosqichli autentifikatsiya (2FA)</h3>
            <div class="flex items-center justify-between">
                <p class="text-gray-600">Hozirda: <strong class="text-green-600">Yoqilgan</strong></p>
                <form method="POST" action="{{ route('dashboard.2fa.disable') }}">
                    @csrf
                    <button class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700">O'chirish</button>
                </form>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-8">
            <h3 class="text-xl font-bold mb-4">Faol seanslar</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center border-b pb-4">
                    <div>
                        <p class="font-semibold">Chrome • Windows 11 • Toshkent</p>
                        <p class="text-sm text-gray-500">Oxirgi faollik: hozir</p>
                    </div>
                    <span class="text-green-600 text-sm">Bu qurilma</span>
                </div>
            </div>
        </div>
    </div>
@endsection
