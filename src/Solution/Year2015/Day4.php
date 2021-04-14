<?php
declare(strict_types=1);

namespace AdventOfCode\Solution\Year2015;

use AdventOfCode\Solution\SolutionInterface;
use SplFileObject;

class Day4 implements SolutionInterface
{
    public function part1(SplFileObject $input): string
    {
        return (string) $this->getLowestNumber(
            $input,
            function ($hash) {
                return substr($hash, 0, 5) === '00000';
            }
        );
    } 

    public function part2(SplFileObject $input): string
    {
        return (string) $this->getLowestNumber(
            $input,
            function ($hash) {
                return substr($hash, 0, 6) === '000000';
            }
        );
    }

    private function getLowestNumber(SplFileObject $input, callable $condition)
    {
        $secret = $input->fgets();

        $number = 0;

        do {
            $hash = md5($secret . ++$number);
        } while (call_user_func($condition, $hash) === false);

        return $number;
    }
}
