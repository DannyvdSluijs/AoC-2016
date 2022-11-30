<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2016;

use Dannyvdsluijs\AdventOfCode2016\Concerns\ContentReader;

class Day05
{
    use ContentReader;

    public function partOne(): string
    {
        $doorId = $this->readInput();
        $password = '';
        $index = 0;

        while(strlen($password) < 8) {
            $hash = md5($doorId . (string) $index);
            if (str_starts_with($hash, '00000')) {
                $password .= $hash[5];
            }

            $index++;
        }

        return $password;
    }

    public function partTwo(): string
    {
        $doorId = $this->readInput();
        $password = [];
        $index = 0;

        while(count($password) < 8) {
            $hash = md5($doorId . (string) $index);
            if (str_starts_with($hash, '00000')) {
                if (!array_key_exists($hash[5], $password) && $hash[5] <= 7) {
                    $password[$hash[5]] = $hash[6];
                    printf("%d%%\r\n", count($password) / 8 * 100);
                }
            }

            $index++;
        }

        ksort($password);
        var_dump($password);
        return implode($password);
    }
}