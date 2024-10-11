<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2016;

use Dannyvdsluijs\AdventOfCode2016\Concerns\ContentReader;

class Day16
{
    use ContentReader;

    public function partOne(): string
    {
        $content = $this->readInput();
        $content = $this->dragonCurve($content, 272);
        return $this->checksum($content);
    }

    public function partTwo(): string
    {
        $content = $this->readInput();
        $content = $this->dragonCurve($content, 35651584);
        return $this->checksum($content);
    }

    private function dragonCurve(string $a, int $limit): string
    {
        while (strlen($a) < $limit) {
            $b = strtr(strrev($a), [0 => 1, 1 => 0]);
            $a .= '0' . $b;
        }

        return substr($a, 0, $limit);
    }

    private function checksum(string $content): string
    {
        $len = strlen($content);
        $result = '';
        for ($i = 0; $i < $len; $i += 2) {
            $result .= $content[$i] === $content[$i + 1] ? '1' : '0';
        }

        return strlen($result) % 2 === 0 ? $this->checksum($result) : $result;
    }
}