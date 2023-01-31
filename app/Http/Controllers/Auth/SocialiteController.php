<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SocialAccount;
use App\Models\User;
use App\Models\Timeline;
use App\Models\ProfileUsers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    /**
     * @param $provider
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * @param $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleProvideCallback($provider)
    {
        try {

            $user = Socialite::driver($provider)->user();

        }catch (Exception $e) {
            return redirect()->back();
        }

        $authUser = $this->findOrCreateUser($user, $provider);

        Auth()->login($authUser, true);

        return redirect()->route('dashboard');

    }

    /**
     * @param $socialUser
     * @param $provider
     * @return mixed
     */
    public function findOrCreateUser($socialUser, $provider)
    {
        $socialAccount = SocialAccount::where('provider_id', $socialUser->getId())
            ->where('provider_name', $provider)
            ->first();

        if ($socialAccount) {

            return $socialAccount->user;

        } else {

            $user = User::where('email', $socialUser->getEmail())->first();

            if (! $user) {
                $user = User::create([
                    'name' => $socialUser->name,
                    'email' => $socialUser->email,
                    'role' => "Calon Peserta",
                    // 'password' => Hash::make($socialUser->password),
                    'created_at' => now()
                ]);
                $usersid  = User::orderBy('id', 'DESC')->first();
                ProfileUsers::create([
                    'user_id' => $usersid->id,
                    'nama' => $socialUser->name,
                    'email' => $socialUser->email,
                    'created_at' => now()
                ]);
                Timeline::create([
                    'user_id' => $usersid->id,
                    'status' => "Bergabung",
                    'pesan' => 'Membuat Akun baru',
                    'tgl_update' => now(),
                    'created_at' => now()
                ]);
            }

            $user->socialAccounts()->create([
                'provider_id'   => $socialUser->getId(),
                'provider_name' => $provider
            ]);

            return $user;

        }
    }
}
