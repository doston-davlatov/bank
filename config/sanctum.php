<?php

use Laravel\Sanctum\Sanctum;

return [

    /*
    |--------------------------------------------------------------------------
    | Stateful domenlar (Cookie orqali ishlaydigan frontendlar)
    |--------------------------------------------------------------------------
    | Bu yerga sherikning frontend ishlayotgan domen yoki IP:portlarni yozasiz.
    | Masalan: localhost:3000, 127.0.0.1:3000, 172.16.5.163:3000
    |
    | Agar faqat Bearer token (API) ishlatmoqchi boʻlsangiz – bu qatorni oʻzgartirmasangiz ham boʻladi.
    */
    'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', sprintf(
        '%s%s',
        'localhost,localhost:3000,127.0.0.1,127.0.0.1:8000,::1',
        Sanctum::currentApplicationUrlWithPort()
    ))),

    /*
    |--------------------------------------------------------------------------
    | Qaysi guardlar ishlatiladi
    |--------------------------------------------------------------------------
    | Odatda shu holatda qoldiramiz
    */
    'guard' => ['web'],

    /*
    |--------------------------------------------------------------------------
    | Tokenning amal qilish muddati (daqiqalarda)
    |--------------------------------------------------------------------------
    | 72 soat = 72 × 60 = 4320 daqiqa
    | Shu qatorni yoqsangiz – barcha yangi tokenlar avtomatik 72 soat yashaydi
    */
    'expiration' => 4320,    // ← 72 soatlik token uchun shuni yozing!

    /*
    |--------------------------------------------------------------------------
    | Token prefiksi (ixtiyoriy – xavfsizlik uchun)
    |--------------------------------------------------------------------------
    | GitHub va boshqa platformalar tokenni repo’ga yuklanganda ogohlantirsin desangiz
    */
    'token_prefix' => env('SANCTUM_TOKEN_PREFIX', ''),

    /*
    |--------------------------------------------------------------------------
    | Sanctum middleware’lari
    |--------------------------------------------------------------------------
    | Odatda tegilmaydi
    */
    'middleware' => [
        'authenticate_session' => Laravel\Sanctum\Http\Middleware\AuthenticateSession::class,
        'encrypt_cookies' => Illuminate\Cookie\Middleware\EncryptCookies::class,
        'validate_csrf_token' => Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
    ],

];
