<!DOCTYPE html>
@extends('layouts.app')

@section('title', 'Bosh sahifa')

@section('content')
    <div class="text-center py-20 bg-gradient-to-b from-blue-600 to-indigo-800 text-white rounded-2xl">
        <h1 class="text-5xl font-bold mb-4">Xush kelibsiz, MyBank ga!</h1>
        <p class="text-xl mb-8">Eng tezkor va xavfsiz onlayn banking</p>
        <a href="{{ route('register') }}" class="bg-white text-blue-600 px-8 py-4 rounded-full text-lg font-bold hover:bg-gray-100">
            Hisob ochish
        </a>
    </div>
@endsection
