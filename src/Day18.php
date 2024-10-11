<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2016;

use Dannyvdsluijs\AdventOfCode2016\Concerns\ContentReader;

class Day18
{
    use ContentReader;

    public function partOne(): string
    {
        $currentRow = $this->readInput();
        $safeTileCount = 0;

        for ($x = 0; $x < 40; $x++) {
            $safeTileCount += substr_count($currentRow, ".");

            $currentRow = $this->nextRow($currentRow);
        }

        return (string) $safeTileCount;
    }

    public function partTwo(): string
    {
        $currentRow = $this->readInput();
        $safeTileCount = 0;

        for ($x = 0; $x < 400000; $x++) {
            $safeTileCount += substr_count($currentRow, ".");

            $currentRow = $this->nextRow($currentRow);
        }

        return (string) $safeTileCount;
    }

    private function nextRow(mixed $currentRow): string
    {
        $length = strlen($currentRow);
        $nextRow = '';

        // First tile in the next row is a copy of the second tile from the current row
        $nextRow .= $currentRow[1];
        for ($x = 1; $x < $length - 1; $x++) {
            $nextRow .= ($currentRow[$x - 1] === '^' && $currentRow[$x + 1] === '.') || ($currentRow[$x - 1] === '.' && $currentRow[$x + 1] === '^') ? '^' : '.';
        }

        // Last tile in the next row is a copy of the second to last tile from the current row
        $nextRow .= $currentRow[strlen($currentRow) - 2];

        return $nextRow;
    }
}