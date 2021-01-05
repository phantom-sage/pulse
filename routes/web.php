<?php

use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\LocationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::resource('pharmacies', PharmacyController::class);
Route::resource('medicines', MedicineController::class);
Route::get('medicines/{medicine}/show-medicine-in-map/', [MedicineController::class, 'show_medicine_in_map'])
    ->name('medicines.show.medicine.in.map');
Route::resource('companies', CompanyController::class);
Route::resource('locations', LocationController::class);

Route::view('contact-us', 'contact_us.contact-us')->middleware('auth:web')
->name('contact.us');

Route::post('send-email', function (\Illuminate\Http\Request $request) {
    return $request->all();
})->name('send.email');
