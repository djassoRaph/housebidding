<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'phone_number' => ['required', 'regex:/^0[1-9][0-9]{8}$/'],
                'proof' => ['required', 'file', 'max:5120', 'mimes:pdf,jpg,png'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ],
            [
                'email.email' => 'Veuillez saisir une adresse e-mail valide (ex: nom@domaine.com)',
                'phone_number.regex' => 'Le numéro doit commencer par 0 et contenir exactement 10 chiffres. Exemple : 0612345678',
            ]
        );

        $path = $request->file('proof')->store('public/proofs');

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'proof_path' => $path,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect('/');
    }
}
