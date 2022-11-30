<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2016;

use Dannyvdsluijs\AdventOfCode2016\Concerns\ContentReader;

class Day06
{
    use ContentReader;

    public function partOne(): string
    {
        $content = $this->readInputAsGridOfCharacters();
        $messageLength = count($content[0]);
        $message = '';

        for ($x = 0; $x < $messageLength; $x++) {
            $chars = array_map(fn($line) => $line[$x], $content);
            $charCount = array_count_values($chars);
            arsort($charCount);
            $message .= array_key_first($charCount);
        }

        return $message;
    }

    public function partTwo(): string
    {
        $content = $this->readInputAsGridOfCharacters();
        $messageLength = count($content[0]);
        $message = '';

        for ($x = 0; $x < $messageLength; $x++) {
            $chars = array_map(fn($line) => $line[$x], $content);
            $charCount = array_count_values($chars);
            asort($charCount);
            $message .= array_key_first($charCount);
        }

        return $message;
    }
}