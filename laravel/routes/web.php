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
  
Route::get('/albums', "AlbumsController@index")->name('albums');
Route::get('/albums/{id}/edit','AlbumsController@edit')->where('album','[0-9]+');
Route::get('/albums/create', "AlbumsController@create")->name('album.create');

//laravel usa i nomi delle azioni per fare una determinata cosa
Route::delete('/albums/{album}','AlbumsController@delete')->where('id','[0-9]+');
Route::patch('/albums/{id}','AlbumsController@store');
Route::post('/albums', "AlbumsController@save")->name('album.save');
Route::get('/albums/{id}','AlbumsController@show');
Route::get('/albums/{album}/images','AlbumsController@getImages')->name('album.getimages')->where('album','[0-9]+');


Route::get('usernoalbums',function(){ //utilizzata una funzione anonima
	$usernoalbum=DB::table('users as u')
	->leftJoin('albums as a','u.id','a.user_id')
	->select('u.id','email','name','album_name')
	->whereNull('album_name')
	->get();
	
	return $usernoalbum;
});

/*Route::get('/{name?}/{lastname?}/{age?}', function ($name = '', $lastname='', $age=0) {
	//si potrebbe anche ritornare una view
    return '<h1>Ciao ' . $name . ' '.$lastname .', you are '.$age.' years old</h1>';
})->where([
  		'name' => '[a-zA-Z]+',
  		'lastname' => '[a-zA-Z]+',
  		'age' => '[0-9]{1,3}'
  	]);*/

//images
Route::resource('photos','PhotosController');
