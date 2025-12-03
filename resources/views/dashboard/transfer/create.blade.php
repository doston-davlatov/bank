<!-- resources/views/dashboard/transfer/create.blade.php -->
@extends('layouts.app')
@section('title', 'Pul o'tkazish')
@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-xl p-8">
    <h2 class="text-3xl font-bold mb-6">Pul o'tkazish</h2>
    <form method="POST" action="{{ route('dashboard.transfer.store') }}">
        @csrf
        <div class="grid gap-6">
            <div>
                <label>Qayerdan</label>
                <select name="from_account_id" class="w-full rounded-lg border-gray-300">
                    <option>1234567890 - 12,450,000 so'm</option>
                </select>
            </div>
            <div>
                <label>Qayerga (karta yoki hisob raqami)</label>
                <input type="text" name="to" placeholder="8600 1234 5678 9012" class="w-full rounded-lg border-gray-300">
            </div>
            <div>
                <label>Summa</label>
                <input type="number" name="amount" placeholder="100000" class="w-full rounded-lg border-gray-300">
            </div>
            <div>
                <label>Izoh (ixtiyoriy)</label>
                <textarea name="description" rows="3" class="w-full rounded-lg border-gray-300"></textarea>
            </div>
            <button type="submit" class="bg-blue-600 text-white py-4 rounded-lg text-lg font-bold hover:bg-blue-700">O'tkazish</button>
        </div>
    </form>
</div>
@endsection
