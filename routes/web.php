<?php
// routes/web.php — Laravel 10
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Cashier\OrderController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\ReviewController as CustomerReviewController;

// ── PUBLIC ────────────────────────────────────────────────
Route::get('/',       [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('home.search');

// ── GUEST ONLY ────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',    [AuthController::class, 'login']);
    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// ── EMAIL VERIFICATION ────────────────────────────────────
Route::get('/email/verify', fn () => view('auth.verify-email'))
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [AuthController::class, 'resendVerification'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

Route::post('/email/resend', [AuthController::class, 'resendVerificationGuest'])
    ->middleware('throttle:6,1')
    ->name('verification.resend.email');

// ── AUTHENTICATED + VERIFIED + ACTIVE ─────────────────────
Route::middleware(['auth', 'verified', 'active.user'])->group(function () {

    // Profile (all roles)
    Route::get('/profile',   [ProfileController::class, 'show'])->name('admin.profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('admin.profile.update');

    // ── CUSTOMER ───────────────────────────────────────────
    Route::middleware('role:customer')
        ->prefix('customer')
        ->name('customer.')
        ->group(function () {
            Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');
        });

    // ── ORDERING — customers AND cashiers/admin can place orders ──
    // Customers order for themselves from the dashboard
    // Cashiers/admin order from the POS terminal
    Route::middleware('role:admin,cashier,customer')
        ->prefix('cashier')
        ->name('cashier.')
        ->group(function () {
            Route::get('/orders',          [OrderController::class, 'index'])->name('orders.index');
            Route::post('/orders',         [OrderController::class, 'store'])->name('orders.store');
            Route::get('/orders/products', [OrderController::class, 'getProducts'])->name('orders.products');
        });

    // ── REVIEWS (any verified user who purchased) ──────────
    Route::post('/reviews',         [CustomerReviewController::class, 'store'])->name('reviews.store');
    Route::put('/reviews/{review}', [CustomerReviewController::class, 'update'])->name('reviews.update');

    // ── ADMIN ──────────────────────────────────────────────
    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

            Route::get('products/trashed',       [ProductController::class, 'trashed'])->name('products.trashed');
            Route::delete('product-photos/{photo}', [ProductController::class, 'deletePhoto'])->name('products.photos.delete');
            Route::post('products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
            Route::post('products/import',       [ProductController::class, 'import'])->name('products.import');
            Route::get('products/export',        [ProductController::class, 'export'])->name('products.export');
            Route::resource('products', ProductController::class);

            Route::patch('users/{user}/status', [UserController::class, 'updateStatus'])->name('users.status');
            Route::patch('users/{user}/role',   [UserController::class, 'updateRole'])->name('users.role');
            Route::resource('users', UserController::class);

            Route::get('transactions',                        [TransactionController::class, 'index'])->name('transactions.index');
            Route::patch('transactions/{transaction}/status', [TransactionController::class, 'updateStatus'])->name('transactions.status');
            Route::get('transactions/{transaction}/receipt',  [TransactionController::class, 'receipt'])->name('transactions.receipt');
            Route::get('transactions/{transaction}/pdf',      [TransactionController::class, 'pdf'])->name('transactions.pdf');

            Route::get('reviews',             [ReviewController::class, 'index'])->name('reviews.index');
            Route::delete('reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

            Route::get('reports',            [ReportController::class, 'index'])->name('reports.index');
            Route::get('reports/sales-data', [ReportController::class, 'salesData'])->name('reports.sales-data');
            Route::get('reports/export',     [ReportController::class, 'export'])->name('reports.export');
        });
});