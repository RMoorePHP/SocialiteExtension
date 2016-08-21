<?php 

use Config;
use Auth;
use Session;

use Illuminate\Http\Request;

use RMoore\SocialiteExtension\Models\SocialSite;
use RMoore\SocialiteExtension\Models\SocialLogin;



trait HandlesSocialConnections {
	private function setConfig(SocialSite $provider){
		Config::set("services.{$provider->class}", [
			'client_id' => $provider->app_id,
			'client_secret' => $provider->app_secret,
			'redirect' => route('auth.social.callback', ['provider' => $provider->class])
		]);
	}

    public function redirectToProvider(SocialSite $provider)
    {
        $this->setConfig($provider);
        return Socialite::driver($provider->class)->redirect();
    }

    public function handleProviderCallback(SocialSite $provider)
    {
        $this->setConfig($provider);
        $user = Socialite::driver($provider->class)->user();

        $social = SocialLogin::where('provider_id', $provider->id)->where('social_site_id', $user->id)->first();

        if($social && $social->exists()){
        	return $this->loginUser($social->user);
        }	 

        if(Auth::check()){
			$social = SocialLogin::create([
				'user_id' => Auth::id(),
				'provider_id' => $provider->id,
				'social_site_id' => $user->id
			]);
			session()->flash('success', "Succesfully connected with your $provider->name account.");
        	return redirect('/');
        }       

        session([
        	'user_data' => $user,
        	'social_provider' => $provider->id
        ]);

        return redirect()->intended('/auth/social/details');
    }

    public function getUserDetailsForm(){
    	$user = session('user_data');
    	$provider = SocialSite::find(session('social_provider'));

    	return view('rmoore-socialite-extension::social',
			[
				'username' => $user->nickname,
				'email' => $user->email,
				'provider' => $provider,
			]
		);
    }

    public function setUserDetails(Request $request){
    	$this->validate($request, $this->userValidation());
    	$credentials = [
    		'username' => $request->input('username'),
    		'email' => $request->input('email'),
    	];
    	if(strlen($request->input('password')) >= 1)
    		$credentials['password'] = $request->input('password');

    	$user = $this->registerUser();

    	if(!$user || !$user->exists())
    		return redirect()->back();

    	$social = SocialLogin::create([
    		'user_id' => $user->id,
    		'provider_id' => session('social_provider'),
    		'social_site_id' => session('user_data')['id']
    	]);

    	Auth::login($user);

    	session()->forget('user_data');    	
    	session()->forget('social_provider');

    	return redirect()->intended('/');
    }

    public function getConnectPage(){
    	return view('rmoore-socialite-extension::connect');
    }

    protected function userValidation(){
    	return [];
    }

    protected function registerUser(){
    	$model = Config::get('auth.providers.users.model');
    	return $model::register($credentials);
    }

    protected function loginUser($user){
    	if($user->google2fa_confirmed){
            Session::put('user_id', $user->id);
            return redirect('/auth/2fa');
        }
        Auth::login($user);
        return redirect('/');
    }
}