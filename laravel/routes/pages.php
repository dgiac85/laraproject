<?php
//il PageController serve a controllare le pagine che devono essere caricate
Route::get('about', 'PageController@about'); 
Route::get('blog', 'PageController@blog'); 
Route::get('staff', 'PageController@staff');
Route::get('staffb', 'PageController@staffb');