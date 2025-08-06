<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomFieldController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::resource('contacts', ContactController::class);
Route::resource('contacts', ContactController::class)->except([
    'show'
]);
Route::post('/contacts/store', [ContactController::class, 'store'])->name('contacts.store');
Route::post('/contacts/update/{id}', [ContactController::class, 'update'])->name('contacts.update');
Route::delete('/contacts/delete/{id}', [ContactController::class, 'destroy'])->name('contacts.destroy');
Route::get('/search', [ContactController::class, 'search'])->name('contacts.search');

Route::get('/custom-fields', [CustomFieldController::class, 'index'])->name('custom-fields.index');
Route::post('/custom-fields/store', [CustomFieldController::class, 'store'])->name('custom-fields.store');

Route::get('/contacts/merge-data', [ContactController::class, 'mergeForm'])->name('contacts.merge.form');
Route::post('/contacts/merge', [ContactController::class, 'merge'])->name('contacts.merge');
