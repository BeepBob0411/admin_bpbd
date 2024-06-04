<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ExpenseCategoriesController;
use App\Http\Controllers\Admin\IncomeCategoriesController;

Route::get('/', function () {
    return redirect('/admin/home');
});

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('auth.login');
Route::post('login', 'Auth\LoginController@login')->name('auth.login');
Route::post('logout', 'Auth\LoginController@logout')->name('auth.logout');

// Change Password Routes...
Route::get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
Route::patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');

// Peringatan 
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::resource('peringatan', 'PeringatanController');
});


// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.password.reset');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.password.reset');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('auth.password.reset');

// Registration Routes..
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('auth.register');
Route::post('register', 'Auth\RegisterController@register')->name('auth.register');

Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/home', 'HomeController@index');

    Route::resource('roles', 'Admin\RolesController');
    Route::post('roles_mass_destroy', ['uses' => 'Admin\RolesController@massDestroy', 'as' => 'roles.mass_destroy']);
    Route::resource('users', 'Admin\UsersController');
    Route::post('users_mass_destroy', ['uses' => 'Admin\UsersController@massDestroy', 'as' => 'users.mass_destroy']);
    Route::resource('expense_categories', 'Admin\ExpenseCategoriesController');
    Route::post('expense_categories_mass_destroy', ['uses' => 'Admin\ExpenseCategoriesController@massDestroy', 'as' => 'expense_categories.mass_destroy']);
    Route::resource('income_categories', 'Admin\IncomeCategoriesController');
    Route::post('income_categories_mass_destroy', ['uses' => 'Admin\IncomeCategoriesController@massDestroy', 'as' => 'income_categories.mass_destroy']);
    Route::resource('incomes', 'Admin\IncomesController');
    Route::post('incomes_mass_destroy', ['uses' => 'Admin\IncomesController@massDestroy', 'as' => 'incomes.mass_destroy']);
    Route::resource('expenses', 'Admin\ExpensesController');
    Route::post('expenses_mass_destroy', ['uses' => 'Admin\ExpensesController@massDestroy', 'as' => 'expenses.mass_destroy']);
    Route::resource('monthly_reports', 'Admin\MonthlyReportsController');
    Route::resource('currencies', 'Admin\CurrenciesController');
    Route::post('currencies_mass_destroy', ['uses' => 'Admin\CurrenciesController@massDestroy', 'as' => 'currencies.mass_destroy']);
    Route::post('currencies_restore/{id}', ['uses' => 'Admin\CurrenciesController@restore', 'as' => 'currencies.restore']);
    Route::delete('currencies_perma_del/{id}', ['uses' => 'Admin\CurrenciesController@perma_del', 'as' => 'currencies.perma_del']);

    Route::get('laporan', [ExpenseCategoriesController::class, 'showReports'])->name('laporan.index');
    Route::get('/check-credentials', function () {
        dd(env('GOOGLE_APPLICATION_CREDENTIALS'));
    });

    // Rute untuk menampilkan form create
    Route::get('expense_categories/create', [ExpenseCategoriesController::class, 'create'])->name('expense_categories.create');

    // Rute untuk menyimpan berita
    Route::post('expense_categories/store', [ExpenseCategoriesController::class, 'store'])->name('expense_categories.store');

    Route::get('income_categories/create_from_report/{id}', [IncomeCategoriesController::class, 'createFromReport'])->name('income_categories.create_from_report');
    Route::post('income_categories/store_from_report', [IncomeCategoriesController::class, 'storeFromReport'])->name('income_categories.store_from_report');
    Route::get('income_categories/{id}', [IncomeCategoriesController::class, 'show'])->name('income_categories.show');
    Route::patch('income_categories/{id}', [IncomeCategoriesController::class, 'update'])->name('income_categories.update');
    Route::delete('income_categories/{id}', [IncomeCategoriesController::class, 'destroy'])->name('income_categories.destroy');
    Route::get('income_categories/loadMoreBerita', [IncomeCategoriesController::class, 'loadMoreBerita'])->name('income_categories.loadMoreBerita');
});

?>
