<?php

namespace App\Services;

use App\Models\Game;
use App\Models\User;
use Illuminate\Support\Collection;

class GameService
{
    public const HISTORY_QUANTITY = 3;
    public const MAX_NUMBER = 1000;
    public const LEVELS = [
        ['rate' => 900, 'percentage' => 70],
        ['rate' => 600, 'percentage' => 50],
        ['rate' => 300, 'percentage' => 30],
    ];

    public const DEFAULT_PERCENTAGE = 10;
    public function getUserHistory(User $user): Collection
    {
        return $user->games()
            ->select('number', 'win', 'amount')
            ->orderByDesc('created_at')
            ->limit(self::HISTORY_QUANTITY)
            ->get();
    }

    public function execute(User $user): array
    {
        $number = rand(1, self::MAX_NUMBER);
        $win = $number % 2 === 0;
        $amount = $win ? self::getWinAmount($number) : 0;
        $result = compact('number', 'amount', 'win');

        $user->games()->create($result);

        return $result;
    }

    public static function getWinAmount(int $number): int
    {
         foreach (self::LEVELS as $level) {
             if ($number > $level['rate']) {
                 return ceil($number / 100 * $level['percentage']);
             }
         }
         return ceil($number / 100 * self::DEFAULT_PERCENTAGE);
    }

}
