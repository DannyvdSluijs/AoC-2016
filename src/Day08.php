<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2016;

use Dannyvdsluijs\AdventOfCode2016\Concerns\ContentReader;

class Day08
{
    use ContentReader;

    public function partOne(): string
    {
        $content = $this->readInputAsLines();
        $numberOfColumns = 50;

        $grid = (object) [
            (object) str_split(str_repeat('.', $numberOfColumns)),
            (object) str_split(str_repeat('.', $numberOfColumns)),
            (object) str_split(str_repeat('.', $numberOfColumns)),
            (object) str_split(str_repeat('.', $numberOfColumns)),
            (object) str_split(str_repeat('.', $numberOfColumns)),
            (object) str_split(str_repeat('.', $numberOfColumns)),
        ];

        $this->process($content, $grid, 6, 50);

        $count = 0;
        foreach ($grid as $row) {
            foreach ($row as $pos) {
                if ($pos === '#') {
                    $count++;
                }
            }
        }

        return (string) $count;
    }

    public function partTwo(): string
    {
        $content = $this->readInputAsLines();
        $numberOfColumns = 50;

        $grid = (object) [
            (object) str_split(str_repeat('.', $numberOfColumns)),
            (object) str_split(str_repeat('.', $numberOfColumns)),
            (object) str_split(str_repeat('.', $numberOfColumns)),
            (object) str_split(str_repeat('.', $numberOfColumns)),
            (object) str_split(str_repeat('.', $numberOfColumns)),
            (object) str_split(str_repeat('.', $numberOfColumns)),
        ];
        $this->process($content, $grid, 6, 50);

        foreach ($grid as $row) {
            foreach ($row as $pos) {
                echo $pos === '#' ? '#' : ' ';
            }

            echo PHP_EOL;
        }

        return 'printed above';
    }

    private function process(array $content, object $grid, $numberOfRows, $numberOfColumns): void
    {
        foreach ($content as $line) {
            $parts = explode(' ', $line);

            switch ($parts[0]) {
                case 'rect':
                    [$xMax, $yMax] = array_map(intval(...), explode('x', $parts[1]));
                    for ($y = 0; $y < $yMax; $y++) {
                        for ($x = 0; $x < $xMax; $x++) {
                            $grid->$y->$x = '#';
                        }
                    }

                    break;
                case 'rotate':
                    switch ($parts[1]) {
                        case 'column':
                            [, $col] = array_map(intval(...), explode('=', $parts[2]));
                            $offset = (int) $parts[4];

                            $new = [];
                            for ($row = 0; $row < $numberOfRows; $row++) {
                                $takeFromColumn = ($row + $numberOfRows - $offset) % $numberOfRows;
                                $new[$row] = $grid->$takeFromColumn->$col;
                            }

                            for ($row = 0; $row < $numberOfRows; $row++) {
                                $grid->$row->$col = $new[$row];
                            }

                            break;
                        case 'row':
                            [, $row] = array_map(intval(...), explode('=', $parts[2]));
                            $offset = (int) $parts[4];

                            $new = [];
                            for ($column = 0; $column < $numberOfColumns; $column++) {
                                $takeFromColumn = ($column + $numberOfColumns - $offset) % $numberOfColumns;
                                $new[$column] = $grid->$row->$takeFromColumn;
                            }

                            for ($column = 0; $column < $numberOfColumns; $column++) {
                                $grid->$row->$column = $new[$column];
                            }

                            break;
                        default:
                            throw new \Exception($parts[1] . ' is not supported');
                    }

                    break;
                default:
                    throw new \Exception($parts[0] . ' is not supported');
            }
        }
    }
}