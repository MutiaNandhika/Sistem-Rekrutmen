<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index()
    {
        return view('pelamar.profile');
    }
    
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * ==============================
     * UPDATE DATA DIRI DARI MODAL
     * ==============================
     */
    public function updateDataDiri(Request $request): RedirectResponse
{
    $validated = $request->validate([
        'first_name' => 'required|string|max:50',
        'last_name'  => 'nullable|string|max:50',
        'phone'      => 'nullable|string|max:20',
        'location'   => 'nullable|string|max:100',
        'gender'     => 'nullable|string|max:20',
        'education'  => 'nullable|string|max:50',
        'experience' => 'nullable|string|max:20',
    ]);

    /** @var \App\Models\User $user */
    $user = $request->user();

    $user->update($validated);

    return back()->with('success', 'Data diri berhasil diperbarui.');
}
}
