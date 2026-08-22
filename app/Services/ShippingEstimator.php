<?php

namespace App\Services;

use Carbon\CarbonInterface;

class ShippingEstimator
{
    private const ZONES = [
        'colombia' => [2, 4],
        'ecuador' => [4, 7],
        'venezuela' => [5, 8],
        'panama' => [5, 8],
        'peru' => [6, 9],
        'costa rica' => [6, 9],
        'republica dominicana' => [6, 9],
        'puerto rico' => [6, 9],
        'bolivia' => [7, 10],
        'guatemala' => [7, 10],
        'honduras' => [7, 10],
        'el salvador' => [7, 10],
        'nicaragua' => [7, 10],
        'mexico' => [8, 12],
        'brazil' => [8, 12],
        'chile' => [8, 12],
        'paraguay' => [8, 12],
        'argentina' => [9, 13],
        'uruguay' => [9, 13],
        'estados unidos' => [10, 14],
        'usa' => [10, 14],
        'canada' => [12, 16],
        'espana' => [14, 20],
        'españa' => [14, 20],
    ];

    private const REST_OF_WORLD = [18, 30];

    public function estimate(?string $country, ?CarbonInterface $from = null): array
    {
        [$min, $max] = self::ZONES[strtolower(trim((string) $country))] ?? self::REST_OF_WORLD;

        $from = $from ?? now();

        return [
            'min' => $from->copy()->addDays($min)->startOfDay(),
            'max' => $from->copy()->addDays($max)->startOfDay(),
        ];
    }
}
