<?php

namespace App;

class Adventurer
{
    public function __construct(
        public string $name,
        public Orientation $orientation,
        public int $xPosition,
        public int $yPosition,
        public int $obtainedTreasures = 0,
    ) {}

    public function turnRight(): void
    {
        switch ($this->orientation) {
            case Orientation::North:
                $this->orientation = Orientation::West;
            break;

            case Orientation::West:
                $this->orientation = Orientation::South;
            break;

            case Orientation::South:
                $this->orientation = Orientation::East;
            break;

            case Orientation::East:
                $this->orientation = Orientation::North;
            break;
        }
    }

    public function turnLeft(): void
    {
        switch ($this->orientation) {
            case Orientation::North:
                $this->orientation = Orientation::East;
            break;

            case Orientation::East:
                $this->orientation = Orientation::South;
            break;

            case Orientation::South:
                $this->orientation = Orientation::West;
            break;

            case Orientation::West:
                $this->orientation = Orientation::North;
            break;
        }
    }

    public function moveForward(): void
    {
        switch ($this->orientation) {
            case Orientation::North:
                $this->yPosition--;
            break;

            case Orientation::East:
                $this->xPosition--;
            break;

            case Orientation::South:
                $this->yPosition++;
            break;

            case Orientation::West:
                $this->xPosition++;
            break;
        }
    }

    public function getCoords(): array
    {
        return [$this->xPosition, $this->yPosition];
    }

    public function getTreasure(Cell $cell)
    {
        if ($cell->x === $this->xPosition && $cell->y === $this->yPosition && $cell->type === Types::Treasure) {
            $cell->treasures--;
            $this->obtainedTreasures++;
            if ($cell->treasures === 0) {
                $cell->setType(Types::Plain);
            }
        }
    }
}