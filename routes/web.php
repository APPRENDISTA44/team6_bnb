<?php

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
});

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('admin')
->namespace('Admin')
->name('admin.')
->middleware('auth')
->group(function(){
  Route::resource('apartment','ApartmentController');
});

// Routes per index controller
Route::get('/home', 'IndexController@index')->name('home');

// Routes per show controller
Route::get('/guest/apartment/{id}', 'IndexController@show')->name('guest.show');


// Route per Ajax
Route::post('/home', 'IndexController@coordinatesHandler');

// Route per Email
Route::post('/email/{apartment}','IndexController@emailHandler')->name('email');


// Routes per mostrare i messaggi
Route::get('/messages/{user}', 'IndexController@messages')->name('messages')->middleware('auth');

// Routes per mostrare lista di appartamenti dell'utente specifico
Route::get('/apartment/list/{user}', 'IndexController@apartmentList')->name('admin.apartment.list')->middleware('auth');

// Routes per mostrare statistiche dell'appartamento dell'utente specifico
Route::get('/apartment/chart/{apartment}', 'IndexController@chartHandler')->name('admin.apartment.chart')->middleware('auth');

// Routes per mostrare sposorizzazione dell'appartamento dell'utente specifico
Route::get('/apartment/sponsor/{apartment}', 'IndexController@paymentHandler')->name('admin.apartment.sponsor')->middleware('auth');
