<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2016;

use Dannyvdsluijs\AdventOfCode2016\Concerns\ContentReader;

class Day07
{
    use ContentReader;

    public function partOne(): string
    {
        $content = $this->readInputAsLines();
        $valid = array_filter($content, $this->supportsTls(...));

        return (string) count($valid);
    }

    public function partTwo(): string
    {
        $content = $this->readInputAsLines();
        $valid = array_filter($content, $this->supportsSsl(...));

        return (string) count($valid);
    }

    private function supportsTls(string $ip): bool
    {
        $replacement = str_replace(['[', ']'], '-', $ip);
        $parts = explode('-', $replacement);
        $partsWithAbba = [];
        foreach ($parts as $part) {
            $partLength = strlen($part);
            for ($x = 0; $x < $partLength - 3; $x++) {
                $chunk = substr($part, $x, 4);
                if ($chunk === strrev($chunk) && substr($chunk, 0, 2) !== substr($chunk, 2, 2)) {
                    $partsWithAbba[] = $part;
                    continue 2;
                }
            }
        }

        if (count($partsWithAbba) === 0) {
            return false;
        }

        foreach ($partsWithAbba as $part) {
            if (str_contains($ip, '[' . $part . ']')) {
                return false;
            }
        }

        return true;
    }

    private function supportsSsl(string $ip): bool
    {
        $replacement = str_replace(['[', ']'], '-', $ip);
        $parts = explode('-', $replacement);

        foreach ($parts as $part) {
            if (str_contains($ip, '[' . $part . ']')) {
                continue;
            }

            $partLength = strlen($part);
            for ($x = 0; $x < $partLength - 2; $x++) {
                $chunk = substr($part, $x, 3);
                if ($chunk === strrev($chunk) && $chunk[1] !== $chunk[0]) {
                    foreach ($parts as $innerPart) {
                        if (str_contains($ip, '[' . $innerPart . ']') && str_contains($innerPart, $chunk[1] . $chunk[0] . $chunk[1])) {
                            return true;
                        }
                    }
                }
            }
        }

        return false;
    }
}