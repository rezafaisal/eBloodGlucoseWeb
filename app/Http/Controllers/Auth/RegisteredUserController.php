<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration page.
     */
    public function create(): Response
    {
        return Inertia::render('auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
            'age' => 'required|integer',
            'gender' => ['required', 'in:male,female'],
            'blood_type' => 'required|in:A,B,AB,O',
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'age' => $request->age,
            'gender' => $request->gender,
            'blood_type' => $request->blood_type,
            'height' => $request->height,
        ]);

        $user->weightReadings()->create([
            'weight'       => $request->weight,
            'recorded_at' => now(),
        ]);

        event(new Registered($user));

        $user->assignRole('user');

        Auth::login($user);

        return to_route('dashboard');
    }
}
