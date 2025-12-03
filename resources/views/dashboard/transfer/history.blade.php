@extends('layouts.app')
@section('title', 'O'tkazmalar tarixi')
@section('content')
<h2 class="text-3xl font-bold mb-6">O'tkazmalar tarixi</h2>
<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-6 py-4 text-left">Sana</th>
                <th class="px-6 py-4 text-left">Qayerdan</th>
                <th class="px-6 py-4 text-left">Qayerga</th>
                <th class="px-6 py-4 text-right">Summa</th>
                <th class="px-6 py-4 text-center">Holati</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transfers ?? [] as $t)
            <tr class="border-b hover:bg-gray-50">
                <td class="px-6 py-4">{{ $t->created_at->format('d.m.Y H:i') }}</td>
                <td class="px-6 py-4">{{ $t->from_account ?? '8600****9012' }}</td>
                <td class="px-6 py-4">{{ $t->to_account ?? '9860****5432' }}</td>
                <td class="px-6 py-4 text-right font-bold text-red-600">-{{ number_format($t->amount) }} so'm</td>
                <td class="px-6 py-4 text-center">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $t->status === 'success' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ $t->status === 'success' ? 'Muvaffaqiyatli' : 'Kutilmoqda' }}
                    </span>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center py-12 text-gray-500">O'tkazmalar yo'q</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
