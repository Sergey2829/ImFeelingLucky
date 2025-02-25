<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameRequest;
use App\Services\LinkService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LinkController extends Controller
{
    public function generateLink(GameRequest $request, LinkService $linkService): JsonResponse
    {
        $link = $linkService->makeTemporaryLink($request->input('user_id'));

        return response()->json(['link' => $link], Response::HTTP_CREATED);
    }

    public function deactivateLink(Request $request, LinkService $linkService): JsonResponse
    {
        $linkService->deactivateTemporaryLink($request->input('id'));

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
