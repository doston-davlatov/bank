@extends('layouts.app')
@section('title', 'Sahifa topilmadi')
@section('content')
    <div class="text-center py-20">
        <h1 class="text-9xl font-bold text-gray-300">404</h1>
        <p class="text-2xl text-gray-600 mt-4">Kechirasiz, sahifa topilmadi</p>
        <a href="{{ route('home') }}" class="mt-8 inline-block bg-blue-600 text-white px-8 py-3 rounded-lg">Bosh sahifaga</a>
    </div>
@endsection
