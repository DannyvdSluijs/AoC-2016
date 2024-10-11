<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2016;

use Dannyvdsluijs\AdventOfCode2016\Concerns\ContentReader;

class Day01
{
    use ContentReader;

    public function partOne(): string
    {
        $content = $this->readInput();
        $instructions = explode(',', $content);
        $instructions = array_map(trim(...), $instructions);
        $instructions = array_map(fn(string $instruction) => [$instruction[0], (int) substr($instruction, 1)], $instructions);

        $position = (object) ['x' => 0, 'y' => 0];
        $heading = 0;

        foreach ($instructions as $instruction) {
            $heading = (360 + $heading + ($instruction[0] === 'R' ? 90 : -90)) % 360;
            [$plane, $offset] = match($heading) {
                0 => ['y', 1],
                90 => ['x', 1],
                180 => ['y', -1],
                270 => ['x', -1],
            };
            $position->$plane += $offset * $instruction[1];
        }

        return (string) (abs($position->x) + abs($position->y));
    }

    public function partTwo(): string
    {
        $content = $this->readInput();
        $instructions = explode(',', $content);
        $instructions = array_map(trim(...), $instructions);
        $instructions = array_map(fn(string $instruction) => [$instruction[0], substr($instruction, 1)], $instructions);

        $position = (object) ['x' => 0, 'y' => 0];
        $heading = 0;
        $positions = [];

        foreach ($instructions as $instruction) {
            $heading = (360 + $heading + ($instruction[0] === 'R' ? 90 : -90)) % 360;
            [$plane, $offset] = match($heading) {
                0 => ['y', 1],
                90 => ['x', 1],
                180 => ['y', -1],
                270 => ['x', -1],
            };

            for($c = 1; $c <= $instruction[1]; $c++) {
                $position->$plane += $offset;
                $positionKey = sprintf('%d,%d', $position->x, $position->y);
                if (in_array($positionKey, $positions)) {
                    break 2;
                }

                $positions[] = $positionKey;
            }
        }

        return (string) (abs($position->x) + abs($position->y));
    }
}