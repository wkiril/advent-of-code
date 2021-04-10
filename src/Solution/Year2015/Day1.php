<?php
declare(strict_types=1);

namespace AdventOfCode\Solution\Year2015;

use AdventOfCode\Solution\SolutionInterface;
use SplFileObject;

class Day1 implements SolutionInterface
{
    const UP = '(';
    const DOWN = ')';

    public function part1(SplFileObject $input): string
    {
        $floor = 0;

        foreach ($this->getFloorDelta($input) as $delta) {
            $floor += $delta;
        }

        return (string) $floor;
    }

    public function part2(SplFileObject $input): string
    {
        $floor = 0;
        $position = 0;

        foreach ($this->getFloorDelta($input) as $delta) {
            $position += 1;
            $floor += $delta;

            if ($floor < 0) {
                return (string) $position;
            }
        }

        return 'Santa did not enter the basement';
    }

    private function getFloorDelta(SplFileObject $input)
    {
        while (!$input->eof()) {
            $direction = $input->fgetc();

            if ($direction === self::UP) {
                yield 1;
            } elseif ($direction === self::DOWN) {
                yield -1;
            }
        }
    }
}
