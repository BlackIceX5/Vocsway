<?php

namespace App\Services;
use App\SocialFacebookAccount;
use App\User;
use Laravel\Socialite\Contracts\User as ProviderUser;
use File; 
use Image;

class SocialFacebookAccountService
{
    public function createOrGetUser(ProviderUser $providerUser)
    {
        $account = SocialFacebookAccount::whereProvider('facebook')
            ->whereProviderUserId($providerUser->getId())
            ->first();

        if ($account) {
            return $account->user;
        } else {

            $account = new SocialFacebookAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => 'facebook'
            ]);

            $user = User::whereEmail($providerUser->getEmail())->first();
			
            if (!$user) {
				
				
				$user = User::create([
                    'email' => $providerUser->getEmail(),
                    'name' => $providerUser->getName(),
                    'password' => md5(rand(1,10000)),
					'location' => 'United States'
                ]);
				
				$fileContents = file_get_contents($providerUser->getAvatar());
                File::put(public_path() . '/images/users/' . $user->id . ".jpg", $fileContents);
				$file = $providerUser->avatar_original;
				$file = str_replace('type=small', 'type=large', $file);
				Image::make($file)->resize(333, 333)->save( public_path().'/images/users/' . $user->id . "Full.jpg" );
				
				//$file = str_replace('type=small', 'type=large', $fileContents);
				//File::put(public_path() . '/images/users/' . $user->id . "Full.jpg", $file);
				
            }

            $account->user()->associate($user);
            $account->save();

            return $user;
        }
    }
}






