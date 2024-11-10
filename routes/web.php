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
use App\Http\Controllers\SiteController;
use App\Http\Controllers\VacationController;
use App\Http\Controllers\PointageController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ContactController;


Route::view('/', 'home')->name('home');
Route::view('/about-us', 'about-us')->name('about-us');

Route::view('/contact-us', 'contact-us')->name('contact-us');
Route::view('/services', 'services')->name('services');
Route::view('/requete', 'requete')->name('requete');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
Route::post('/admin/demandes/{id}/traiter', [DemandeController::class, 'traiterDemande'])->name('admin.demandes.traiterDemande');
Route::get('/admin/demandes/{contratId}/traiter', [DemandeController::class, 'afficherTraitement'])->name('admin.demandes.traiter');




// Utilisez Auth::routes() au lieu de définir manuellement les routes d'authentification
Auth::routes();

// Route::get('/home', [HomeController::class, 'index'])->name('home');

// Routes pour la réinitialisation du mot de passe
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');


// Routes protégées
Route::middleware(['auth'])->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Route::get('/contact-us', [ContactController::class, 'index'])->name('contact-us');
    Route::post('/admin/demandes.store', [DemandeController::class, 'store'])->name('admin.demandes.store');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::prefix('admin')->name('admin.')->group(function() {
        Route::resource('agents', AgentController::class);
        Route::resource('vacations', VacationController::class);
        Route::resource('sites', SiteController::class);
        Route::resource('pointages', PointageController::class);
        Route::resource('clients', ClientController::class);
        Route::resource('demandes', DemandeController::class);
        Route::resource('invoices', InvoiceController::class);
        Route::post('invoices/{id}/pay', [InvoiceController::class, 'pay'])->name('admin.invoices.pay');
        Route::post('invoices/{id}/processPayment', [InvoiceController::class, 'processPayment'])->name('admin.invoices.processPayment');
    });

    // Routes pour les agents
    Route::middleware(['auth', 'checkRole:agent'])->group(function() {
        Route::get('/agent/dashboard', [DashboardController::class, 'agentDashboard'])->name('agent.dashboard');
    });

    // Routes pour les clients
    Route::middleware(['auth', 'checkRole:client'])->group(function() {
        Route::get('/client/dashboard', [DashboardController::class, 'clientDashboard'])->name('client.dashboard');
    });

});

