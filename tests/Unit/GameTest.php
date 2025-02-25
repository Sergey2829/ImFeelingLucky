<?php

namespace Tests\Unit;

use App\Services\GameService;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_win_amount_counting(): void
    {
        $numbers = [
            ['value' => 900, 'amount' => 450],
            ['value' => 950, 'amount' => 665],
            ['value' => 300, 'amount' => 30],
            ['value' => 600, 'amount' => 180],
            ['value' => 1, 'amount' => 1],
            ['value' => -1, 'amount' => 0],
        ];

        foreach ($numbers as $number) {
            $winAmount = GameService::getWinAmount($number['value']);
            $this->assertEquals($number['amount'], $winAmount);
        }
    }
}
