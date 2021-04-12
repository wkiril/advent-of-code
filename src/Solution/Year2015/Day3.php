<?php
declare(strict_types=1);

namespace AdventOfCode\Solution\Year2015;

use AdventOfCode\Solution\SolutionInterface;
use RuntimeException;
use SplFileObject;

class Day3 implements SolutionInterface
{
    const MOVE_NORTH = '^';
    const MOVE_SOUTH = 'v';
    const MOVE_EAST = '>';
    const MOVE_WEST = '<';

    public function part1(SplFileObject $input): string
    {
        return (string) $this->getVisitedHousesCount($input);
    }

    public function part2(SplFileObject $input): string
    {
        return (string) $this->getVisitedHousesCount($input, 2);
    }

    private function getVisitedHousesCount(SplFileObject $input, int $santaCount = 1)
    {
        $visitedHouses = [];

        foreach ($this->getVisitedHouseCoordinates($input, $santaCount) as [$x, $y]) {
            if (!isset($visitedHouses[$x][$y])) {
                $visitedHouses[$x][$y] = 0;
            }

            $visitedHouses[$x][$y] += 1;
        }

        return (string) array_reduce(
            $visitedHouses,
            function ($carry, $item) {
                return $carry + count($item);
            },
            0
        );
    }

    private function getVisitedHouseCoordinates(SplFileObject $input, int $santaCount)
    {
        for ($santaIndex = 0; $santaIndex < $santaCount; $santaIndex++) {
            $coordinates[$santaIndex] = [0, 0];
            yield $coordinates[$santaIndex];
        }

        $santaIndex = 0;

        while (false !== ($direction = $input->fgetc())) {
            $coordinates[$santaIndex] = $this->getNextCoordinatesFromDirection(
                $direction,
                $coordinates[$santaIndex]
            );

            yield $coordinates[$santaIndex];

            $santaIndex += 1;
            if ($santaIndex === $santaCount) {
                $santaIndex = 0;
            }
        }
    }

    private function getNextCoordinatesFromDirection(string $direction, array $coordinates): array
    {
        switch ($direction) {
            case self::MOVE_NORTH: return [$coordinates[0], $coordinates[1] + 1];
            case self::MOVE_SOUTH: return [$coordinates[0], $coordinates[1] - 1];
            case self::MOVE_EAST: return [$coordinates[0] + 1, $coordinates[1]];
            case self::MOVE_WEST: return [$coordinates[0] - 1, $coordinates[1]];
            default: throw new RuntimeException('Invalid direction provided: ' . var_export($direction, true));
        }
    }
}
