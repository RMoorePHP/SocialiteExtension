<?php 

Route::group(['prefix' => 'auth/social'], function(){
	Route::post('social/details', 'RMoore\SocialiteExtension\Controllers/SocialController@setUserDetails');
	Route::get('social/details', 'RMoore\SocialiteExtension\Controllers/SocialController@getUserDetailsForm');
	Route::get('social/connect', ['uses' => 'RMoore\SocialiteExtension\Controllers/SocialController@getConnectPage', 'as' => 'auth.social.connect', 'middleware' => ['auth']]);
	Route::get('social/{provider}', ['uses'=>'RMoore\SocialiteExtension\Controllers/SocialController@redirectToProvider', 'as' => 'auth.social.redirect']);
	Route::get('social/{provider}/callback', ['uses'=>'RMoore\SocialiteExtension\Controllers/SocialController@handleProviderCallback', 'as'=>'auth.social.callback']);
});