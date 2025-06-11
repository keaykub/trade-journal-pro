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
use App\Http\Controllers\TradeController;
use Illuminate\Http\Request;
use App\Http\Controllers\PublicTradeController;
use App\Http\Middleware\AdminMiddleware;

// ============================================
// PUBLIC ROUTES (No Authentication Required)
// ============================================

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/pricing', [HomeController::class, 'pricing'])->name('pricing');
Route::get('/faq', [FaqController::class, 'index'])->name('faq');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/demo', [HomeController::class, 'demo'])->name('demo');

// Public shared trades (no auth required)
Route::get('/trades/shared/{id}', [PublicTradeController::class, 'show'])
     ->name('trades.public')
     ->middleware('throttle:30,1'); // 30 views per minute

// ============================================
// SOCIALITE LOGIN ROUTES (Rate Limited)
// ============================================

Route::middleware(['throttle:10,1'])->group(function () {
    // Line Login
    Route::get('/login/line', function () {
        return Socialite::driver('line')->redirect();
    })->name('login.line');

    Route::get('/login/line/callback', function () {
        try {
            $lineUser = Socialite::driver('line')->user();

            $email = $lineUser->getEmail() ?? 'line_' . $lineUser->getId() . '@line.local';

            $user = User::where('line_id', $lineUser->getId())
                ->orWhere('email', $email)
                ->first();

            if (!$user) {
                $user = User::create([
                    'name' => $lineUser->getName() ?? 'Line User',
                    'email' => $email,
                    'line_id' => $lineUser->getId(),
                    'avatar_url' => $lineUser->getAvatar(),
                    'password' => bcrypt(Str::random(32)),
                    'email_verified_at' => now(), // Auto verify for social login
                ]);
            } elseif (is_null($user->line_id)) {
                $user->update([
                    'line_id' => $lineUser->getId(),
                    'avatar_url' => $lineUser->getAvatar(),
                ]);
            }

            Auth::login($user);

            return redirect()->intended('/dashboard');

        } catch (\Exception $e) {
            \Log::error('Line login error: ' . $e->getMessage());
            return redirect('/login')->with('error', 'เกิดข้อผิดพลาดในการเข้าสู่ระบบด้วย Line');
        }
    })->name('login.line.callback');

    // Google Login
    Route::get('/login/google', function () {
        return Socialite::driver('google')->redirect();
    })->name('login.google');

    Route::get('/login/google/callback', function () {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'avatar_url' => $googleUser->getAvatar(),
                    'password' => bcrypt(Str::random(32)),
                    'email_verified_at' => now(), // Auto verify for social login
                ]);
            } else {
                // Update avatar if changed
                $user->update([
                    'avatar_url' => $googleUser->getAvatar(),
                ]);
            }

            Auth::login($user);

            return redirect()->intended('/dashboard');

        } catch (\Exception $e) {
            \Log::error('Google login error: ' . $e->getMessage());
            return redirect('/login')->with('error', 'เกิดข้อผิดพลาดในการเข้าสู่ระบบด้วย Google');
        }
    })->name('login.google.callback');
});

// ============================================
// LOGOUT ROUTE
// ============================================
Route::middleware(['throttle:10,1'])->group(function () {
    Route::post('/logout', function (Request $request) {
        // ไม่ต้องเช็คอะไร logout เลย
        Auth::logout();

        // Clear session ถ้ามี
        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect('/login')->with('message', 'ออกจากระบบเรียบร้อยแล้ว');
    })->name('logout');
});


// ============================================
// PAYMENT ROUTES (Heavy Rate Limiting)
// ============================================

Route::middleware(['auth', 'throttle:3,5'])->group(function () {
    Route::post('/pricing/check-slip', [PricingController::class, 'checkSlip'])
        ->name('pricing.check-slip');
});

// ============================================
// AUTHENTICATED USER ROUTES
// ============================================

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard and main features
    Route::get('/dashboard', App\Livewire\Dashboard::class)
        ->name('dashboard');

    Route::get('/trade', App\Livewire\TradeForm::class)
        ->name('trade');

    Route::get('/analytics', App\Livewire\TradeAnalytics::class)
        ->name('analytics');

    Route::get('/settings', App\Livewire\UserSettings::class)
        ->name('settings');

    // Trade detail view
    Route::get('/trades/{id}', App\Livewire\TradeDetail::class)
        ->name('trades.show');

    // Trade actions (rate limited)
    Route::middleware(['throttle:30,1'])->group(function () {
        Route::patch('/trades/{id}/status', [TradeController::class, 'updateStatus'])
             ->name('trades.update-status');

        Route::post('/trades/{id}/toggle-share', [TradeController::class, 'toggleShare'])
             ->name('trades.toggle-share');

        Route::delete('/trades/{id}', [TradeController::class, 'destroy'])
             ->name('trades.destroy');
    });
});

// ============================================
// ADMIN ROUTES (Strict Access Control)
// ============================================

Route::middleware(['auth', 'verified', AdminMiddleware::class, 'throttle:60,1'])->prefix('admin')->group(function () {
    Route::get('/manage-members', App\Livewire\Admin\ManageMembers::class)
        ->name('admin.manage-members');

    // Add more admin routes here as needed
    // Route::get('/payments', App\Livewire\Admin\ManagePayments::class)
    //     ->name('admin.manage-payments');
});

// ============================================
// LEGACY ROUTES (Keep for compatibility)
// ============================================

// These can be removed if not used
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Include Laravel Breeze auth routes
require __DIR__.'/auth.php';
