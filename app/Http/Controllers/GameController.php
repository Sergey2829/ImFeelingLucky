<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameRequest;
use App\Models\User;
use App\Services\GameService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Symfony\Component\HttpFoundation\Response;

class GameController extends Controller
{
    public function index(Request $request, GameService $gameService): InertiaResponse
    {
        $user = User::find($request->input('user_id'));
        $history = $gameService->getUserHistory($user);

         return Inertia::render('Game', [
             'history' => $history,
             'userId' => $user->id,
         ]);
    }

    public function runGame(GameRequest $request, GameService $gameService): JsonResponse
    {
         $result = $gameService->execute($request->user());

         return response()->json($result, Response::HTTP_CREATED);
    }

}
