<?php
declare(strict_types=1);

namespace AdventOfCode\Solution;

use SplFileObject;

interface SolutionInterface
{
    public function part1(SplFileObject $input): string;

    public function part2(SplFileObject $input): string;
}
