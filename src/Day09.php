<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2016;

use Dannyvdsluijs\AdventOfCode2016\Concerns\ContentReader;

class Day09
{
    use ContentReader;

    public function partOne(): string
    {
        $content = $this->readInput();

        return (string) $this->decodeCount($content);
    }

    public function partTwo(): string
    {
        $content = $this->readInput();


        return (string) $this->decodeCount($content, true);
    }

    private function decodeCount(string $content, bool $useV2 = false): int
    {
        if (!str_contains($content, '(') && !str_contains($content, ')')) {
            return strlen($content);
        }

        $length = strlen($content);
        $pointer = 0;
        $count = 0;

        while($pointer < $length) {
            $char = $content[$pointer];

            if ($char === '(') {
                $counterBracket = strpos($content, ')', $pointer);
                $escapedMarker = substr($content, $pointer + 1,  $counterBracket - $pointer - 1);
                [$size, $times] = array_map(intval(...), explode('x', $escapedMarker));
                $pointer += strlen($escapedMarker) + 2;

                $compressed = substr($content, $pointer, $size);
                $pointer += $size;

                if ($useV2) {
                    $count += $times * $this->decodeCount($compressed, true);
                } else {
                    $count += $size * $times;
                }

                continue;
            }

            $count++;
            $pointer ++;
        }

        return $count;
    }
}