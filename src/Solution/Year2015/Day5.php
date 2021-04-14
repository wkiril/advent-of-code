<?php
declare(strict_types=1);

namespace AdventOfCode\Solution\Year2015;

use AdventOfCode\Solution\SolutionInterface;
use SplFileObject;

class Day5 implements SolutionInterface
{
    public function part1(SplFileObject $input): string
    {
        $niceCount = 0;

        foreach ($this->getStrings($input) as $string) {
            if (
                !$this->containsNaughtyString($string)
                && $this->containsThreeVowels($string)
                && $this->containsDoubleLetter($string)
            ) {
                $niceCount += 1;
            }
        }

        return (string) $niceCount;
    }

    public function part2(SplFileObject $input): string
    {
        $niceCount = 0;

        foreach ($this->getStrings($input) as $string) {
            if (
                $this->containsPairTwice($string)
                && $this->containsRepeatingLetterWithGap($string)
            ) {
                $niceCount += 1;
            }
        }

        return (string) $niceCount;
    }

    private function getStrings(SplFileObject $input)
    {
        while (!$input->eof()) {
            yield $input->fgets();
        }
    }

    private function containsNaughtyString(string $string): bool
    {
        $naughtyStrings = ['ab', 'cd', 'pq', 'xy'];
        foreach ($naughtyStrings as $naughtyString) {
            if (strpos($string, $naughtyString) !== false) {
                return true;
            }
        }

        return false;
    }

    private function containsThreeVowels(string $string): bool
    {
        $vowels = ['a', 'e', 'i', 'o', 'u'];
        $count = 0;
        foreach ($vowels as $vowel) {
            $count += substr_count($string, $vowel);

            if ($count >= 3) {
                return true;
            }
        }

        return false;
    }

    private function containsDoubleLetter(string $string): bool
    {
        for ($index = 0, $length = strlen($string); $index < $length - 1; $index++) {
            if ($string[$index] === $string[$index + 1]) {
                return true;
            }
        }

        return false;
    }

    private function containsPairTwice(string $string): bool
    {
        for ($index = 0, $length = strlen($string); $index < $length - 2; $index++) {
            $pair = substr($string, $index, 2);
            if (strpos($string, $pair, $index + 2) !== false) {
                return true;
            }
        }

        return false;
    }

    private function containsRepeatingLetterWithGap(string $string): bool
    {
        for ($index = 0, $length = strlen($string); $index < $length - 2; $index++) {
            if ($string[$index] === $string[$index + 2]) {
                return true;
            }
        }

        return false;
    }
}
