<?php
declare(strict_types=1);

namespace AdventOfCode\Solution\Year2015;

use AdventOfCode\Solution\SolutionInterface;
use SplFileObject;

class Day2 implements SolutionInterface
{
    public function part1(SplFileObject $input): string
    {
        $totalSize = 0;

        foreach ($this->getSides($input) as [$l, $w, $h]) {
            $areas = [
                $l * $w,
                $w * $h,
                $h * $l,
            ];

            $totalSize += 2 * array_sum($areas) + min($areas);
        }

        return (string) $totalSize;
    }

    public function part2(SplFileObject $input): string
    {
        $totalLength = 0;

        foreach ($this->getSides($input) as [$l, $w, $h]) {
            $perimeters = [
                2 * ($l + $w),
                2 * ($w + $h),
                2 * ($h + $l),
            ];

            $totalLength += min($perimeters) + $l * $w * $h;
        }

        return (string) $totalLength;
    }

    private function getSides(SplFileObject $input)
    {
        while (!$input->eof()) {
            yield array_map('intval', explode('x', $input->fgets()));
        }
    }
}
