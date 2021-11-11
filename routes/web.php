<?php

Route::view('/', 'home')->name('home');
Route::view('/quienes-somos', 'about')->name('about');

Route::view('/sellar', 'stamps/stamp')->name('stamp');
Route::view('/verificar', 'stamps/check')->name('check');

Route::post('stamp', 'StampController@stamp')->name('stamp.stamp');
Route::post('check', 'StampController@check')->name('stamp.check');

Route::view('/contacto', 'contact')->name('contact');
Route::post('contact', 'MessageController@store')->name('messages.store');

Auth::routes([
	'register' => true,
]);
