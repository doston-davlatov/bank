@extends('layouts.app')
@section('content')
    <div class="max-w-md mx-auto bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-center mb-6">Emailni tasdiqlang</h2>
        <p class="text-center text-gray-600 mb-6">Emailingizga tasdiqlash havolasi yuborildi.</p>

        <form method="POST" action="{{ route('verification.send') }}" class="text-center">
            @csrf
            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
                Yangi havola yuborish
            </button>
        </form>
    </div>
@endsection
