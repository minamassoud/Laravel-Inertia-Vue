<?php

namespace App\Http\Controllers;

use App\ValidationRules\UserRules;
use Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function create(Request $request)
    {
        return Inertia::render('Profile/Edit', [
            'user' => $request->user()->only(['name', 'email', 'email_verified_at']),
        ]);
    }

    public function updateInformation(Request $request, UserRules $rules)
    {
        $user = $request->user();
        $validated = $request->validate($rules->forProfileUpdate($user));

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        if ($user->wasChanged()) {
            return redirect()->back()->with(['status' => 'User updated correctly']);
        }

        return redirect()->back()->with(['status' => 'Nothing changed']);
    }

    public function updatePassword(Request $request, UserRules $rules)
    {
        $user = $request->user();
        $validated = $request->validate($rules->forPasswordUpdate());

        $user->update($validated);

        if ($user->wasChanged()) {
            return redirect()->back()->with(['status' => 'Password Updated']);
        }

        return redirect()->back()->with(['status' => 'Nothing changed']);
    }

    public function destroy(Request $request, UserRules $rules)
    {
        $request->validate($rules->forDeletion());

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
