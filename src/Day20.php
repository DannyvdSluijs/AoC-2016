<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2016;

use Dannyvdsluijs\AdventOfCode2016\Concerns\ContentReader;

class Day20
{
    use ContentReader;

    public function partOne(): string
    {
        $rules = array_map(
            static function ($in) {
                [$low, $high] = explode('-', $in, 2);

                return ['low' => (int) $low, 'high' => (int) $high];
            },
            $this->readInputAsLines()
        );

        $allowedIpAddresses = $this->findAllowedIpAddresses(4_294_967_295, $rules);

        return (string) array_shift($allowedIpAddresses);
    }

    public function partTwo(): string
    {
        $rules = array_map(
            static function ($in) {
                [$low, $high] = explode('-', $in, 2);

                return ['low' => (int) $low, 'high' => (int) $high];
            },
            $this->readInputAsLines()
        );

        $allowedIpAddresses = $this->findAllowedIpAddresses(4_294_967_295, $rules);

        return (string) count($allowedIpAddresses);
    }

    /**
     * @param $rules list<{low: int, high: int}>
     * @return list<int>
     */
    private function findAllowedIpAddresses(int $max, array $rules): array
    {
        $currentValue = 0;
        $allowedValues = [];

        usort($rules, static fn ($a, $b) => $a['low'] <=> $b['low']);
        $currentRule = current($rules);
        while ($currentValue <= $max) {
            while ($currentValue > $currentRule['high']) {
                $next = next($rules);
                if ($next === false) {
                    $allowedValues[] = $currentValue;
                    $currentValue++;
                    continue 2;
                }
                $currentRule = current($rules);
            }

            if ($currentValue < $currentRule['low']) {
                $allowedValues[] = $currentValue;
                $currentValue++;
                continue;
            }

            $currentValue = $currentRule['high'] + 1;
        }

        return $allowedValues;
    }
}