<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2016;

use Dannyvdsluijs\AdventOfCode2016\Concerns\ContentReader;

class Day21
{
    use ContentReader;

    public function partOne(): string
    {
        $operations = $this->parseOperationsFromInput();
        $data = 'abcdefgh';
        $length = strlen($data);

        foreach ($operations as $index => $operation) {
            printf('%d: %s (%s)' . PHP_EOL, $index, $data, $operation['origin']);
            $data = match($operation['identifier']) {
                'swapPosition' => $this->swapPosition($data, $operation['left'], $operation['right']),
                'swapLetter' => $this->swapLetter($data, $operation['left'], $operation['right']),
                'reversePositions' => $this->reversePositions($data, $operation['left'], $operation['right']),
                'rotate' => $this->rotate($data, $operation['direction'], $operation['amount']),
                'movePosition' => $this->movePosition($data, $operation['left'], $operation['right']),
                'rotateBasedOnPositionOfLetter' => $this->rotateBasedOnPositionOfLetter($data, $operation['letter']),
            };

            if (strlen($data) !== $length) {
                throw new \Exception('Operation altered length');
            }
        }

        return $data;
    }

    public function partTwo(): string
    {
        $operations = $this->parseOperationsFromInput();
        $operations = $this->reverseOperations($operations);
        $data = 'fbgdceah';
        $length = strlen($data);

        foreach ($operations as $index => $operation) {
            $inputData = $data;
            $data = match($operation['identifier']) {
                'swapPosition' => $this->swapPosition($data, $operation['left'], $operation['right']),
                'swapLetter' => $this->swapLetter($data, $operation['left'], $operation['right']),
                'reversePositions' => $this->reversePositions($data, $operation['left'], $operation['right']),
                'rotate' => $this->rotate($data, $operation['direction'], $operation['amount']),
                'movePosition' => $this->movePosition($data, $operation['left'], $operation['right']),
                'rotateBasedOnPositionOfLetter' => $this->rotateBasedOnPositionOfLetterReversed($data, $operation['letter']),
            };

            if (strlen($data) !== $length) {
                throw new \Exception('Operation altered length');
            }

            printf('%d: %s (%s) %s' . PHP_EOL, $index, $inputData, $operation['origin'], $data);
        }

        return $data;
    }

    private function swapPosition(string $data, $left, $right)
    {
        $tmp = $data[$left];
        $data[$left] = $data[$right];
        $data[$right] = $tmp;

        return $data;
    }

    private function swapLetter(string $data, $left, $right): string
    {
        return strtr($data, [$left => $right, $right => $left]);
    }

    private function reversePositions(mixed $data, mixed $left, mixed $right): string
    {
        return substr($data, 0, $left) . strrev(substr($data, $left, $right - $left + 1)) . substr($data, $right + 1);
    }

    private function rotate(mixed $data, mixed $direction, mixed $amount): string
    {
        $amount %= strlen($data);
        if ($amount ===0) {
            return $data;
        }
        if ($direction === 'left') {
            return substr($data, $amount) . substr($data, 0, $amount);
        }
        return substr($data, $amount * -1) . substr($data, 0, strlen($data) - $amount);
    }

    private function movePosition(mixed $data, mixed $left, mixed $right): string
    {
        $letter = $data[$left];
        $leftover = substr($data, 0, $left) . substr($data, $left + 1);
        return substr($leftover, 0, $right) . $letter . substr($leftover, $right);
    }

    private function rotateBasedOnPositionOfLetter(mixed $data, mixed $letter): string
    {
        $pos = strpos($data, $letter);
        return $this->rotate($data, 'right', 1 + $pos + ($pos >= 4 ? 1 :0));
    }

    private function rotateBasedOnPositionOfLetterReversed(mixed $data, mixed $letter): string
    {
        $length = strlen($data);
        for($x = 0; $x < $length; $x++) {
            $possibleInput = substr($data . $data, $x, $length);
            if ($this->rotateBasedOnPositionOfLetter($possibleInput, $letter) === $data) {
                return $possibleInput;
            }
        }

        return '';
    }

    public function parseOperationsFromInput(): array
    {
        $operations = array_map(
            static function (string $in) {
                $words = explode(' ', $in);
                $identifier = $words[0] . ucfirst($words[1]);

                return match ($identifier) {
                    'swapPosition',
                    'movePosition' => [
                        'identifier' => $identifier,
                        'left' => (int)$words[2],
                        'right' => (int)$words[5],
                        'origin' => $in,
                    ],
                    'swapLetter', => [
                        'identifier' => $identifier,
                        'left' => $words[2],
                        'right' => $words[5],
                        'origin' => $in,
                    ],
                    'reversePositions' => [
                        'identifier' => $identifier,
                        'left' => (int)$words[2],
                        'right' => (int)$words[4],
                        'origin' => $in,
                    ],
                    'rotateLeft',
                    'rotateRight' => [
                        'identifier' => $words[0],
                        'direction' => $words[1],
                        'amount' => (int)$words[2],
                        'origin' => $in,
                    ],
                    'rotateBased' => [
                        'identifier' => 'rotateBasedOnPositionOfLetter',
                        'letter' => $words[6],
                        'origin' => $in,
                    ],
                    default => throw new \Exception(sprintf('Invalid identifier "%s"', $identifier))
                };
            }, $this->readInputAsLines()
        );
        return $operations;
    }

    public function reverseOperations(array $operations): array
    {
        $reverse = [];
        $operations = array_reverse($operations);
        foreach ($operations as $operation) {
            $reverse[] = match ($operation['identifier']) {
                'swapPosition',
                'movePosition' => [
                    'identifier' => $operation['identifier'],
                    'left' => $operation['right'],
                    'right' => $operation['left'],
                    'origin' => $operation['origin'],
                ],
                'rotate' => [
                    'identifier' => $operation['identifier'],
                    'direction' => $operation['direction'] === 'left' ? 'right' : 'left',
                    'amount' => $operation['amount'],
                    'origin' => $operation['origin'],
                ],
                'reversePositions', 'swapLetter', 'rotateBasedOnPositionOfLetter' => $operation,
                default => throw new \Exception(sprintf('Unhandled case: %s (%s)', $operation['identifier'], $operation['origin'])),
            };
        }

        return $reverse;
    }
}