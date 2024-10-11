<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2016;

use Dannyvdsluijs\AdventOfCode2016\Concerns\ContentReader;

class Day10
{
    use ContentReader;

    public function partOne(): string
    {
        return $this->solve(1);
    }

    public function partTwo(): string
    {
        return (string) $this->solve(2);
    }

    private function solve(int $part)
    {
        $content = $this->readInputAsLines();
        $state = [];
        $rules = [];
        $comparing = [];

        foreach ($content as $line) {
            $parts = explode(' ', $line);
            if (str_starts_with($line, 'value')) {
                $value = (int) $parts[1];
                $bot = $parts[4] . $parts[5];
                $current = $state[$bot] ?? [];
                $current[] = $value;
                $state[$bot] = $current;
            }

            if (str_starts_with($line, 'bot')) {
                $rules[$parts[0] . $parts[1]] = ['key' => $parts[0] . $parts[1], 'low' => $parts[5] . $parts[6], 'high' => $parts[10] . $parts[11]];
            }
        }

        while(true) {
            $matches = array_filter($state, fn($v, $k) => str_starts_with($k, 'bot') && count($v) === 2, ARRAY_FILTER_USE_BOTH);
            if ($matches === []) {
                break;
            }

            $botKey = array_key_first($matches);
            $bot = array_shift($matches);
            $rule = $rules[$botKey];
            $state[$botKey] = [];
            $low = min($bot);
            $high = max($bot);
            $comparing[$botKey] = [$low, $high];

            $lowTargetState = $state[$rule['low']] ?? [];
            $lowTargetState[] = $low;
            $state[$rule['low']] = $lowTargetState;

            $highTargetState = $state[$rule['high']] ?? [];
            $highTargetState[] = $high;
            $state[$rule['high']] = $highTargetState;
        }

        $matches = array_filter($comparing, fn($v, $k) => str_starts_with($k, 'bot') && $v === [17, 61], ARRAY_FILTER_USE_BOTH);
        if ($matches === []) {
            throw new \Exception('No solution');
        }

        if ($part === 1) {
            return array_key_first($matches);
        }

        if ($part === 2) {
            return $state['output0'][0] * $state['output1'][0] * $state['output2'][0];
        }

        return null;
    }
}