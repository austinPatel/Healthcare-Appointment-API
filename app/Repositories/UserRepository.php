<?php
namespace App\Repositories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class UserRepository{
    // Use ResponseAPI Trait in this repository
    
    public function getUserById($id)
    {
        $user = User::findOrFail($id);
        return $user;
    }

    /*
        User Create|Update
    */
    public function requestUser(array $data)
    {
        // $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        event(new Registered($user));
        return $user;
    }
    /*
        Check User email verify or not
    */
    public function checkUserByEmail($email)
    {
        $user = User::where('email', $email)->first(); // need to verify email_verify_at not null
        return $user;
    }

    public function login(array $data)
    {
        $user = User::where('email', $data['email'])->first();
        if (!$user || !$token = Auth::attempt($data)) {
            return $user;
        }
    }

}
