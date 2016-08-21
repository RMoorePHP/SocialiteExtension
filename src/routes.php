<?php 

Route::group(['prefix' => 'auth/social', 'middleware' => 'web'], function(){
	Route::post('details', 'RMoore\SocialiteExtension\Controllers\SocialController@setUserDetails');
	Route::get('details', 'RMoore\SocialiteExtension\Controllers\SocialController@getUserDetailsForm');
	Route::get('connect', ['uses' => 'RMoore\SocialiteExtension\Controllers\SocialController@getConnectPage', 'as' => 'auth.social.connect', 'middleware' => ['auth']]);
	Route::get('{provider}', ['uses'=>'RMoore\SocialiteExtension\Controllers\SocialController@redirectToProvider', 'as' => 'auth.social.redirect']);
	Route::get('{provider}/callback', ['uses'=>'RMoore\SocialiteExtension\Controllers\SocialController@handleProviderCallback', 'as'=>'auth.social.callback']);
});