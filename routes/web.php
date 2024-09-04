<?php
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AgentController;

Route::get('/', function () {
    return view('auth/login');
});

// Utilisez Auth::routes() au lieu de définir manuellement les routes d'authentification
Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Routes pour la réinitialisation du mot de passe
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// Routes protégées
Route::middleware(['auth'])->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('/admin/agents', AgentController::class);

    // Routes pour les agents
    Route::middleware(['auth', 'checkRole:agent'])->group(function() {
        Route::get('/agent/dashboard', [DashboardController::class, 'agentDashboard'])->name('agent.dashboard');
    });

    // Routes pour les clients
    Route::middleware(['auth', 'checkRole:client'])->group(function() {
        Route::get('/client/dashboard', [DashboardController::class, 'clientDashboard'])->name('client.dashboard');
    });
});

