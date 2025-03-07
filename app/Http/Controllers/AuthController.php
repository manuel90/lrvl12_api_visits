<?php

namespace App\Http\Controllers;

use App\Exceptions\GeneralException;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

use App\Models\User;

class AuthController extends Controller
{
    /**
     * POST /api/login
     * Log in the user if the credentials are valid.
     * */
    public function login(Request $request)
    {

        # 0 - Perform form validations.
        $request->validate([
            'email' => 'required|string|max:180',
            'password' => 'required|string|max:100',
        ]);

        # 1 - Verification if the user with the data exists.
        $myUser = User::where('email', $request->input('email'))->firstOrFail();
        
        # 2 - Check the password
        if (! $myUser || ! Hash::check($request->password, $myUser->password)) {
            throw ValidationException::withMessages([
                'email' => [__('The provided credentials are incorrect.')],
            ]);
        }

        $token = $myUser->createToken('api_login');

        return ['token' => $token->plainTextToken];
    }


    /**
     * POST /api/register
     * Create a user.
     */
    public function register(Request $request)
    {

        # 0 - Perform form validations.
        $request->validate([
            'fullname' => 'required|string|max:100',
            'email' => 'required|string|max:180',
            'password' => [
                'required',
                'string',
                // Enforces a minimum length of 8, requires letters, numbers, and symbols
                Password::min(8)
                    ->max(100)
                    ->letters()
                    ->numbers()
                    ->symbols(),
            ],

        ]);

        # 1 - Perform unique user validation.
        $user = User::where('email', $request->input('email'))->first();

        if ($user) {
            throw new GeneralException(__("User already exists."));
        }

        # 2 - Create a new user.
        $user = new User();
        
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->name = $request->input('fullname');
        
        $user->saveOrFail();

        # 3 - Return response.
        return $user;
    }
    
    /**
     * GET /api/me
     * Returns the auth user.
     */
    public function me(Request $request) {
        return $request->user();
    }
}
