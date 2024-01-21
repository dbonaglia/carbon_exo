<?php

declare(strict_types=1);

use App\Map;
use PHPUnit\Framework\TestCase;

final class MapTest extends TestCase
{
    public function testThatAnAdventurerCanNotBePlacedOnMountain(): void
    {
        $input = explode("\r\n", file_get_contents(__DIR__ . '/input1.csv'));

        $formatedInputAsArray = [];
        foreach ($input as $line) {
            $formatedInputAsArray[] = explode(";", $line);
        }

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("An adventurer can't be placed on a mountain.");
        new Map($formatedInputAsArray);
    }

    public function testAMountainCanNotBePlacedOutOfTheMap(): void
    {
        $input = explode("\r\n", file_get_contents(__DIR__ . '/input2.csv'));

        $formatedInputAsArray = [];
        foreach ($input as $line) {
            $formatedInputAsArray[] = explode(";", $line);
        }

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("A cell should be placed in the grid.");
        new Map($formatedInputAsArray);
    }

    public function testATreasureCanNotBePlacedOutOfTheMap(): void
    {
        $input = explode("\r\n", file_get_contents(__DIR__ . '/input3.csv'));

        $formatedInputAsArray = [];
        foreach ($input as $line) {
            $formatedInputAsArray[] = explode(";", $line);
        }

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("A cell should be placed in the grid.");
        new Map($formatedInputAsArray);
    }

    public function testAAdventurerCanNotMoveOutOfTheMap(): void
    {
        $input = explode("\r\n", file_get_contents(__DIR__ . '/input4.csv'));

        $formatedInputAsArray = [];
        foreach ($input as $line) {
            $formatedInputAsArray[] = explode(";", $line);
        }

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("An adventurer can not move out of the grid.");
        $map = new Map($formatedInputAsArray);
        $map->executeMoves();
    }
}
