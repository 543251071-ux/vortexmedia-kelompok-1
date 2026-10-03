<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        $loginInput = trim($this->input('email'));
        $password = trim($this->input('password'));
        $remember = $this->boolean('remember');

        // 1. Try standard Auth attempt via Email
        if (Auth::attempt(['email' => $loginInput, 'password' => $password], $remember)) {
            return;
        }

        // 2. Try standard Auth attempt via Nama / Username
        if (Auth::attempt(['nama' => $loginInput, 'password' => $password], $remember)) {
            return;
        }

        // 3. Fallback: Search user case-insensitively and check plain-text or hash
        $user = User::whereRaw('LOWER(email) = ?', [Str::lower($loginInput)])
            ->orWhereRaw('LOWER(nama) = ?', [Str::lower($loginInput)])
            ->first();

        if ($user) {
            $authenticated = false;

            if (Str::startsWith($user->password, ['$2y$', '$2b$', '$2a$'])) {
                if (Hash::check($password, $user->password)) {
                    $authenticated = true;
                }
            } else {
                if (trim($user->password) === $password) {
                    $authenticated = true;
                    // Auto-hash plain text password to Bcrypt
                    $user->password = $password;
                    $user->save();
                }
            }

            if ($authenticated) {
                Auth::login($user, $remember);
                return;
            }
        }

        // Failed authentication: throwing custom error message without rate limiting / cooldown
        throw ValidationException::withMessages([
            'email' => 'Email/Username atau password yang Anda masukkan salah.',
        ]);
    }
}
