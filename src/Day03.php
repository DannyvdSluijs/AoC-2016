<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2016;

use Dannyvdsluijs\AdventOfCode2016\Concerns\ContentReader;

class Day03
{
    use ContentReader;

    public function partOne(): string
    {
        $triangles = $this->readInputAsGridOfNumbers();

        $possible = 0;
        foreach ($triangles as $t) {
            if ($t[0] + $t[1] > $t[2] && $t[0] + $t[2] > $t[1] && $t[1] + $t[2] > $t[0]) {
                $possible++;
            }
        }

        return (string) $possible;
    }

    public function partTwo(): string
    {
        $triangles = $this->readInputAsGridOfNumbers();

        $possible = 0;
        $totalRows = count($triangles);
        for ($row = 0; $row < $totalRows; $row += 3) {
            for ($col = 0; $col < 3; $col++) {
                if ($triangles[$row][$col] + $triangles[$row+1][$col] > $triangles[$row+2][$col]
                && $triangles[$row][$col] + $triangles[$row+2][$col] > $triangles[$row+1][$col]
                && $triangles[$row+1][$col] + $triangles[$row+2][$col] > $triangles[$row][$col]
                ) {
                    $possible++;
                }
            }
        }

        return (string) $possible;
    }
}