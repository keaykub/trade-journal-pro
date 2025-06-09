<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\AboutController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PricingController;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use App\Models\User;
use App\Livewire\Dashboard;
use App\Http\Controllers\Api\ImageUploadController;
use App\Http\Controllers\TradeController;
use Illuminate\Http\Request;
use App\Http\Controllers\PublicTradeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/pricing', [HomeController::class, 'pricing'])->name('pricing');
Route::get('/faq', [FaqController::class, 'index'])->name('faq');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/demo', [HomeController::class, 'demo'])->name('demo');

// Socialite login routes (Line)
Route::get('/login/line', function () {
    return Socialite::driver('line')->redirect();
})->name('login.line');

Route::get('/login/line/callback', function () {
    $lineUser = Socialite::driver('line')->user();

    $email = $lineUser->getEmail() ?? 'line_' . $lineUser->getId() . '@example.com';

    $user = User::where('line_id', $lineUser->getId())
        ->orWhere('email', $email)
        ->first();

    if (! $user) {
        $user = User::create([
            'name' => $lineUser->getName(),
            'email' => Str::uuid() . '@line.local',
            'line_id' => $lineUser->getId(),
            'password' => bcrypt(Str::random(32)),
        ]);
    } elseif (is_null($user->line_id)) {
        $user->update([
            'line_id' => $lineUser->getId(),
        ]);
    }

    Auth::login($user);

    return redirect()->intended('/dashboard');
});

// Socialite login routes (Google)
Route::get('/login/google', function () {
    return Socialite::driver('google')->redirect();
})->name('login.google');

Route::get('/login/google/callback', function () {
    $googleUser = Socialite::driver('google')->user();

    $user = User::where('email', $googleUser->getEmail())->first();

    if (! $user) {
        $user = User::create([
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'avatar_url' => $googleUser->getAvatar(),
            'password' => bcrypt(Str::random(32)), // ใส่ไว้เฉย ๆ ไม่ได้ใช้จริง
        ]);
    }

    Auth::login($user);

    return redirect()->intended('/dashboard');
});

//pricing(check-slip)
Route::post('/pricing/check-slip', [PricingController::class, 'checkSlip'])
    ->name('pricing.check-slip')
    ->middleware('auth');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

/* Route::post('/upload-image-temp', function (\Illuminate\Http\Request $request) {
    if ($request->hasFile('file')) {
        $path = $request->file('file')->store('temp-trades', 'public');
        return response()->json(['path' => $path]);
    }
    return response()->json(['error' => 'No file uploaded'], 400); // <<-- คุณเจอตรงนี้
}); */

Route::get('/trades/shared/{id}', [PublicTradeController::class, 'show'])
     ->name('trades.public');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', App\Livewire\Dashboard::class)->name('dashboard');
    Route::get('/trade', App\Livewire\TradeForm::class)->name('trade');
    Route::get('/analytics', App\Livewire\TradeAnalytics::class)->name('analytics');

    Route::get('/trades/{id}', App\Livewire\TradeDetail::class)
    ->name('trades.show');

    Route::patch('/trades/{id}/status', [TradeController::class, 'updateStatus'])
         ->name('trades.update-status');

    Route::post('/trades/{id}/toggle-share', [TradeController::class, 'toggleShare'])
         ->name('trades.toggle-share');

    Route::delete('/trades/{id}', [TradeController::class, 'destroy'])
         ->name('trades.destroy');

    // Logout route
    Route::post('/logout', function (Request $request) {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');
});

Route::post('/upload-trade-images', [ImageUploadController::class, 'uploadTradeImages']);
Route::delete('/delete-trade-image', [ImageUploadController::class, 'deleteTradeImage']);

require __DIR__.'/auth.php';
