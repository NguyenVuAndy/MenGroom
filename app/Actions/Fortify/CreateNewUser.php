<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;


class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'sdt' => ['required', 'string', 'max:12', 'unique:User,sdt'],
            'password' => $this->passwordRules(),
        ])->validate();

        return User::create([
            'hoten' => $input['name'],
            'email' => $input['email'],
            'sdt' => $input['sdt'],
            'pass_hash' => Hash::make($input['password']),
        ]);
    }
}
