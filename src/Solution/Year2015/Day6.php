<?php
declare(strict_types=1);

namespace AdventOfCode\Solution\Year2015;

use AdventOfCode\Solution\SolutionInterface;
use SplFileObject;

class Day6 implements SolutionInterface
{
    private const ACTION_TURN_ON = 'turn on';
    private const ACTION_TURN_OFF = 'turn off';
    private const ACTION_TOGGLE = 'toggle';
    private const ACTIONS = [
        self::ACTION_TURN_ON,
        self::ACTION_TURN_OFF,
        self::ACTION_TOGGLE,
    ];

    public function part1(SplFileObject $input): string
    {
        $map = [];

        foreach ($this->getLines($input) as $line) {
            $instructions = $this->getInstructions($line);

            for ($x = $instructions['start'][0]; $x <= $instructions['end'][0]; $x++) {
                for ($y = $instructions['start'][1]; $y <= $instructions['end'][1]; $y++) {
                    switch ($instructions['action']) {
                        case self::ACTION_TURN_ON:
                            $map[$x][$y] = 1;
                            break;
                        case self::ACTION_TURN_OFF:
                            if (isset($map[$x][$y])) {
                                unset($map[$x][$y]);
                            }
                            break;
                        case self::ACTION_TOGGLE:
                            if (isset($map[$x][$y])) {
                                unset($map[$x][$y]);
                            } else {
                                $map[$x][$y] = 1;
                            }
                            break;
                    }
                }
            }
        }

        $count = 0;
        foreach ($map as $row) {
            foreach ($row as $column) {
                $count++;
            }
        }

        return (string) $count;
    }

    public function part2(SplFileObject $input): string
    {
        $map = [];

        foreach ($this->getLines($input) as $line) {
            $instructions = $this->getInstructions($line);

            for ($x = $instructions['start'][0]; $x <= $instructions['end'][0]; $x++) {
                for ($y = $instructions['start'][1]; $y <= $instructions['end'][1]; $y++) {
                    switch ($instructions['action']) {
                        case self::ACTION_TURN_ON:
                            $map[$x][$y] = ($map[$x][$y] ?? 0) + 1;
                            break;
                        case self::ACTION_TURN_OFF:
                            if (isset($map[$x][$y])) {
                                $map[$x][$y] -= 1;
                                if ($map[$x][$y] === 0) {
                                    unset($map[$x][$y]);
                                }
                            }
                            break;
                        case self::ACTION_TOGGLE:
                            $map[$x][$y] = ($map[$x][$y] ?? 0) + 2;
                            break;
                    }
                }
            }
        }

        $total = 0;
        foreach ($map as $row) {
            foreach ($row as $brightness) {
                $total += $brightness;
            }
        }

        return (string) $total;
    }

    private function getLines(SplFileObject $input)
    {
        while (!$input->eof()) {
            yield $input->fgets();
        }
    }

    private function getInstructions(string $line): array
    {
        $pattern = '/^(' . implode('|', self::ACTIONS) . ')\s([\d,]+)\sthrough\s([\d,]+)$/';
        
        if (!preg_match($pattern, $line, $matches)) {
            throw new Exception('Invalid line supplied: ' . $line);
        }

        return [
            'action' => $matches[1],
            'start' => array_map('intval', explode(',', $matches[2])),
            'end' => array_map('intval', explode(',', $matches[3])),
        ];
    }
}
