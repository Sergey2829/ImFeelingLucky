<?php

namespace App\Services;

use App\Models\Link;
use Illuminate\Support\Facades\URL;

class LinkService
{
    public function makeTemporaryLink(int $userId): array
    {
        $link = URL::temporarySignedRoute('lucky.game', now()->addDays(7), ['user_id' => $userId]);
        parse_str(parse_url($link, PHP_URL_QUERY), $query);
        $signature = $query['signature'];
        $temporaryLink = Link::create([
            'signature' => $signature,
            'user_id' => $userId,
            'valid' => true,
        ]);

        return ['id' => $temporaryLink->id, 'url' => $link];
    }

    public function deactivateTemporaryLink(int $id): void
    {
         Link::query()->where('id', $id)->update(['valid' => 0]);
    }

}
