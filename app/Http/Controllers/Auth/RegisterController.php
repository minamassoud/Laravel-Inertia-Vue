<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\RegisterAction;
use App\ValidationRules\UserRules;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class RegisterController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request, RegisterAction $action, UserRules $rules): RedirectResponse
    {
        $validated = $request->validate($rules->forCreation());

        $action->handle($validated);

        return redirect()->route('home');
    }
}
