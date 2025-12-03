<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest; // Email verification uchun qo'shdim
use Illuminate\Http\Request; // Resend uchun kerak
use App\Http\Controllers\Web\{
    DashboardController,
    ProfileController,
    AccountWebController,
    TransactionWebController,
    TransferWebController,
    CardWebController,
    BeneficiaryWebController,
    SecurityController,
    SupportController
};

// ========================
// 1. Ochiq (public) veb-saytlar
// ========================
Route::view('/', 'welcome')->name('home');
Route::view('/about', 'pages.about')->name('about');
Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/terms', 'pages.terms')->name('terms');
Route::view('/privacy', 'pages.privacy')->name('privacy');

// ========================
// 2. Auth qismlari (forgot password va reset – agar Breeze yo'q bo'lsa)
// ========================
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    // Parolni tiklash logikasi (Fortify/Breeze auto handle qiladi, lekin misol)
    $request->validate(['email' => 'required|email']);
    // Status yuborish
    return back()->with('status', 'Parol tiklash havolasi yuborildi!');
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    // Reset logikasi (Fortify auto)
    return redirect()->route('login')->with('status', 'Parol o\'zgartirildi!');
})->middleware('guest')->name('password.update');

// ========================
// 3. Email verification (To'liq qildim: notice, verify, resend)
// ========================
Route::middleware('auth')->group(function () { // Auth guruh qildim optimal uchun
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill(); // Emailni verified qilish
        return redirect('/dashboard')->with('status', 'Email tasdiqlandi!');
    })->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Tasdiqlash havolasi yuborildi!');
    })->middleware('throttle:6,1')->name('verification.send'); // Resend qo'shdim, throttle bilan
});

// ========================
// 4. Faqat autentifikatsiya qilingan va email tasdiqlangan foydalanuvchilar
// ========================
Route::middleware(['auth', 'verified']) // 'auth:sanctum' ni 'auth' ga o'zgartirdim (agar SPA bo'lsa, 'auth:sanctum' qaytaring)
->prefix('dashboard')
    ->name('dashboard.')
    ->group(function () {
        // Bosh sahifa
        Route::get('/', [DashboardController::class, 'index'])->name('index');

        // Profil (sub-group qildim optimal uchun)
        Route::name('profile.')->group(function () {
            Route::get('/profile', [ProfileController::class, 'edit'])->name('edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('destroy');
        });

        // Hisobvaraqlari (Accounts) – resource to'g'ri
        Route::resource('accounts', AccountWebController::class)->parameters(['accounts' => 'account']);

        // Tranzaksiyalar tarihi
        Route::get('/transactions', [TransactionWebController::class, 'index'])->name('transactions.index');
        Route::get('/transactions/{transaction}', [TransactionWebController::class, 'show'])->name('transactions.show');
        Route::get('/accounts/{account}/transactions', [TransactionWebController::class, 'byAccount'])->name('accounts.transactions');

        // Pul o'tkazmalari (throttle qo'shdim security uchun)
        Route::get('/transfer', [TransferWebController::class, 'create'])->name('transfer.create');
        Route::post('/transfer', [TransferWebController::class, 'store'])->middleware('throttle:60,1')->name('transfer.store');
        Route::get('/transfer/history', [TransferWebController::class, 'history'])->name('transfer.history');
        Route::get('/transfer/{transfer}', [TransferWebController::class, 'show'])->name('transfer.show');

        // Doimiy beneficiarylar (resource ni to'liq qildim, except o'rniga only ishlatish mumkin)
        Route::resource('beneficiaries', BeneficiaryWebController::class)->except(['show']);

        // Karta boshqaruvi
        Route::resource('cards', CardWebController::class)->only(['index', 'create', 'store', 'destroy']);
        Route::post('/cards/{card}/block', [CardWebController::class, 'block'])->name('cards.block');
        Route::post('/cards/{card}/unblock', [CardWebController::class, 'unblock'])->name('cards.unblock');
        Route::post('/cards/{card}/set-limit', [CardWebController::class, 'setLimit'])->name('cards.set-limit');

        // Xavfsizlik va 2FA (sub-group)
        Route::name('security.')->group(function () {
            Route::get('/security', [SecurityController::class, 'index'])->name('index');
            Route::post('/2fa/enable', [SecurityController::class, 'enable2FA'])->middleware('throttle:6,1')->name('2fa.enable');
            Route::post('/2fa/disable', [SecurityController::class, 'disable2FA'])->middleware('throttle:6,1')->name('2fa.disable');
            Route::get('/devices', [SecurityController::class, 'devices'])->name('devices');
            Route::delete('/devices/{device}', [SecurityController::class, 'revokeDevice'])->name('devices.revoke');
        });

        // Texnik qo'llab-quvvatlash (sub-group)
        Route::name('support.')->group(function () {
            Route::get('/support', [SupportController::class, 'create'])->name('create');
            Route::post('/support', [SupportController::class, 'store'])->middleware('throttle:60,1')->name('store');
            Route::get('/support/tickets', [SupportController::class, 'index'])->name('index');
            Route::get('/support/tickets/{ticket}', [SupportController::class, 'show'])->name('show');
        });
    });

// ========================
// 5. 404 – Barcha boshqa URL lar uchun
// ========================
Route::fallback(function () {
    return view('errors.404');
})->name('fallback');
