<?php

use App\Models\Album;
use App\User;

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

/*->where('name','[a-zA-Z]+')
  ->where('lastname','[a-zA-Z]+');*/
  //si può fare anche con un solo where
  
Route::get('/albums', function(){
	return User::all(); //se si fa User::truncate() si cancellano tutti i dati in user
});

Route::get('/{name?}/{lastname?}/{age?}', function ($name = '', $lastname='', $age=0) {
	//si potrebbe anche ritornare una view
    return '<h1>Ciao ' . $name . ' '.$lastname .', you are '.$age.' years old</h1>';
})->where([
  		'name' => '[a-zA-Z]+',
  		'lastname' => '[a-zA-Z]+',
  		'age' => '[0-9]{1,3}'
  	]);


