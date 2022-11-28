<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2016;

use Dannyvdsluijs\AdventOfCode2016\Concerns\ContentReader;

class Day02
{
    use ContentReader;

    public function partOne(): string
    {
        $instructions = $this->readInputAsGridOfCharacters();

        $map = [
            1 => ['L' => 1, 'U' => 1, 'R' => 2, 'D' => 4],
            2 => ['L' => 1, 'U' => 2, 'R' => 3, 'D' => 5],
            3 => ['L' => 2, 'U' => 3, 'R' => 3, 'D' => 6],
            4 => ['L' => 4, 'U' => 1, 'R' => 5, 'D' => 7],
            5 => ['L' => 4, 'U' => 2, 'R' => 6, 'D' => 8],
            6 => ['L' => 5, 'U' => 3, 'R' => 6, 'D' => 9],
            7 => ['L' => 7, 'U' => 4, 'R' => 8, 'D' => 7],
            8 => ['L' => 7, 'U' => 5, 'R' => 9, 'D' => 8],
            9 => ['L' => 8, 'U' => 6, 'R' => 9, 'D' => 9],
        ];

        $code = '';
        $pos = 5;
        foreach ($instructions as $instruction) {
            foreach ($instruction as $step) {
                $pos = $map[$pos][$step];
            }
            $code .= (string) $pos;
        }

        return $code;
    }

    public function partTwo(): string
    {
        $instructions = $this->readInputAsGridOfCharacters();

        $map = [
            '1' => ['L' => '1', 'U' => '1', 'R' => '1', 'D' => '3'],
            '2' => ['L' => '2', 'U' => '2', 'R' => '3', 'D' => '6'],
            '3' => ['L' => '2', 'U' => '1', 'R' => '4', 'D' => '7'],
            '4' => ['L' => '3', 'U' => '4', 'R' => '4', 'D' => '8'],
            '5' => ['L' => '5', 'U' => '5', 'R' => '6', 'D' => '5'],
            '6' => ['L' => '5', 'U' => '2', 'R' => '7', 'D' => 'A'],
            '7' => ['L' => '6', 'U' => '3', 'R' => '8', 'D' => 'B'],
            '8' => ['L' => '7', 'U' => '4', 'R' => '9', 'D' => 'C'],
            '9' => ['L' => '8', 'U' => '9', 'R' => '9', 'D' => '9'],
            'A' => ['L' => 'A', 'U' => '6', 'R' => 'B', 'D' => 'A'],
            'B' => ['L' => 'A', 'U' => '7', 'R' => 'C', 'D' => 'D'],
            'C' => ['L' => 'B', 'U' => '8', 'R' => 'C', 'D' => 'C'],
            'D' => ['L' => 'D', 'U' => 'B', 'R' => 'D', 'D' => 'D'],
        ];

        $code = '';
        $pos = 5;
        foreach ($instructions as $instruction) {
            foreach ($instruction as $step) {
                $pos = $map[$pos][$step];
            }
            $code .= (string) $pos;
        }

        return $code;
    }
}