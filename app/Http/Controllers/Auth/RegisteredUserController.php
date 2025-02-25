<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\LinkService;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;


class RegisteredUserController extends Controller
{

    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }


    public function store(RegisterRequest $request, LinkService $linkService): Response
    {
        $user = User::create($request->validated());
        Auth::login($user);
        $link = $linkService->makeTemporaryLink($user->id);

        return Inertia::render('Dashboard', [
            'link' => $link['url']
        ]);
    }
}
