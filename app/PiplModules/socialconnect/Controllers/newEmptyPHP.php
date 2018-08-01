<?php
class FacebookLogin {
    /**
     * Since facebook will give you name, email, gender by default,
     * You'll only need to initialize Facebook scopes after getting permission
     */
    const facebookScope = {
        'user_birthday',
        'user_location',
    };
    /**
     * Initialize Facebook fields to override
     */
    const facebookFields = [
        'name', // Default
        'email', // Default
        'gender', // Default
        'birthday', // I've given permission
        'location', // I've given permission
    ];
    public function facebookRedirect()
    {
        return Socialite::driver('facebook')->fields(self::facebookFields)->scopes(self::facebookScope)->redirect();
    }

    public function facebookCallback()
    {
        $facebook = Socialite::driver('facebook')->fields(self::facebookFields)->user();
    }
}
