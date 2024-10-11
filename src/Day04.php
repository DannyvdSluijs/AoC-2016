<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2016;

use Dannyvdsluijs\AdventOfCode2016\Concerns\ContentReader;

class Day04
{
    use ContentReader;

    public function partOne(): string
    {
        $content = $this->readInputAsLines();
        $content = array_map(function(string $line) {
            $matches = [];
            preg_match('/([a-z\-]*)(\d*)([\[a-z\-\]]*)/', $line, $matches);
            return [$matches[1], (int) $matches[2], str_replace(['[', ']'], '', $matches[3])];
        }, $content);

        $sum = 0;
        foreach ($content as $c) {
            if ($this->calculateChecksum($c[0]) === $c[2]) {
                $sum += $c[1];
            }
        }

        return (string) $sum;
    }

    public function partTwo(): string
    {
        $content = $this->readInputAsLines();
        $content = array_map(function(string $line) {
            $matches = [];
            preg_match('/([a-z\-]*)(\d*)([\[a-z\-\]]*)/', $line, $matches);
            return [$matches[1], (int) $matches[2], str_replace(['[', ']'], '', $matches[3])];
        }, $content);

        $rooms = [];
        foreach ($content as $c) {
            if ($this->calculateChecksum($c[0]) === $c[2]) {
                $rooms[$c[1]] = $this->decrypt($c[0], $c[1]) . ' ' . $c[1] .  PHP_EOL;
            }
        }

        $match = array_filter($rooms, fn (string $room) => str_contains($room, 'northpole'));

        return (string) array_shift($match);
    }

    private function calculateChecksum(string $room): string
    {
        $room = str_replace('-', '', $room);
        $chars = str_split($room);
        $charCount = array_count_values($chars);
        arsort($charCount);

        $mapped = [];
        foreach ($charCount as $k => $v) {
            $mapped[$k] = $v * 100000 - ord($k);
        }

        arsort($mapped);

        return implode('', array_keys(array_slice($mapped, 0, 5)));
    }

    private function decrypt(string $room, int $sectorId): string
    {
        $sectorId %= 26;
        $chars = str_split($room);
        $limit = ord('z');
        foreach ($chars as $k => $v) {
            if ($v === '-') {
                $chars[$k] = ' ';
                continue;
            }

            $ord = ord($v);
            $newOrd = $ord + $sectorId;
            if ($newOrd > $limit) {
                $newOrd = 96 + $newOrd % $limit;
            }

            $chars[$k] = chr($newOrd);
        }

        return implode('', $chars);
    }
}