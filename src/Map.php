<?php

namespace App;

use App\Cell;
use App\Types;
use Exception;

class Map
{
    public int $maxWidth;
    public int $maxHeight;
    public array $cells = [];

    public function __construct(
        public array $input,
    ) {
        $this->generateBaseMap($input);
        $this->placeAdventurer($input);
    }

    private function generateBaseMap(array $input): void
    {
        foreach ($input as $line) {
            switch ($line[0]) {
                case 'C':
                    $this->maxWidth = $line[1];
                    $this->maxHeight = $line[2];
                    $this->generateMapCells();
                break;
            }
        }
    }

    private function generateMapCells(): void
    {
        for ($i=0;$i < $this->maxHeight;$i++) {
            for ($o=0;$o < $this->maxWidth;$o++) {
                $cell = new Cell(Types::Plain, $o, $i);
                $this->cells[] = $cell;
            }
        }

        foreach ($this->input as $line) {
            if ($line[0] === Types::Mountain->value || $line[0] === Types::Treasure->value) {

                if ((int) $line[1] > $this->maxWidth || (int) $line[2] > $this->maxHeight) {
                    throw new Exception('A cell should be placed in the grid.');
                }

                $cell = $this->getCell((int) $line[1],(int) $line[2]);
                
                if ($line[0] === Types::Treasure->value) {
                    $cell->setType(Types::from($line[0]), $line[3]);
                } else {
                    $cell->setType(Types::from($line[0]));
                }
                $this->setCell($cell);
            }
        }
    }

    public function renderMap()
    {
        $width = (40*$this->maxWidth)+($this->maxWidth*2);
        echo '<div id="container" style="width:' . $width . 'px;">';

        for ($i=0;$i < $this->maxHeight;$i++) {
            for ($o=0;$o < $this->maxWidth;$o++) {
                $cell = $this->getCell($o, $i);
                $cell->render();
            }
        }

        echo '</div><br> <hr>';
    }

    private function getCell(int $x, int $y): ?Cell
    {
        foreach ($this->cells as $cell) {
            if ($cell->x == $x && $cell->y == $y) {
                return $cell;
            }
        }

        return null;
    }

    private function setCell(Cell $inputCell): void
    {
        if ($inputCell->x > $this->maxWidth || $inputCell->y > $this->maxHeight) {
            throw new Exception('A cell should be placed in the grid.');
        }

        foreach ($this->cells as $key => $cell) {
            if ($cell->x == $inputCell->x && $cell->y == $inputCell->y) {
                $this->cells[$key] = $inputCell;
            }
        }
    }

    public function placeAdventurer(array $input): void
    {
        foreach ($input as $line) {
            if ($line[0] === 'A') {
                $cell = $this->getCell($line[2], $line[3]);

                if ($cell->type === Types::Mountain) {
                    throw new Exception("An adventurer can't be placed on a mountain.");
                }

                $cell->adventurer = new Adventurer(
                    $line[1],
                    Orientation::from($line[4]),
                    $line[2],
                    $line[3]
                );
            }
        }
    }

    public function getAdventurerByName(string $name): ?Adventurer
    {
        foreach ($this->cells as $cell) {
            if ($cell->adventurer?->name === $name) {
                return $cell->adventurer;
            }
        }
    }

    public function executeMoves(): void
    {
        $movesSequence = [];
        $adventurer = null;
        foreach ($this->input as $line) {
            if ($line[0] === 'A') {
                for ($i=0;$i < strlen($line[5]);$i++) {
                    $movesSequence[] = Moves::from(substr($line[5], $i, 1));
                }
                $adventurer = $this->getAdventurerByName($line[1]);
            }
        }

        foreach ($movesSequence as $move) {
            switch ($move) {
                case Moves::TurnRight:
                    $adventurer->turnRight();
                break;

                case Moves::TurnLeft:
                    $adventurer->turnLeft();
                break;

                case Moves::Forward:
                    $adventurerCoords = $adventurer->getCoords();
                    $actualCell = $this->getCell($adventurerCoords[0], $adventurerCoords[1]);
                    switch ($adventurer->orientation) {
                        case Orientation::North:
                            $destinationCell = $this->getCell($adventurerCoords[0], $adventurerCoords[1]-1);
                            if (!$destinationCell) {
                                throw new Exception ("An adventurer can not move out of the grid.");
                            }
                            
                            
                            if ($destinationCell->type === Types::Mountain) {
                                throw new Exception ("An adventurer can not move on a mountain.");
                            }
                            
                            $adventurer->moveForward();
                            $destinationCell->adventurer = $adventurer;
                            $adventurer->getTreasure($destinationCell);
                            $actualCell->adventurer = null;
                        break;

                        case Orientation::West:
                            $destinationCell = $this->getCell($adventurerCoords[0]+1, $adventurerCoords[1]);
                            if (!$destinationCell) {
                                throw new Exception ("An adventurer can not move out of the grid.");
                            }
                            
                            
                            if ($destinationCell->type === Types::Mountain) {
                                throw new Exception ("An adventurer can not move on a mountain.");
                            }
                            
                            $adventurer->moveForward();
                            $destinationCell->adventurer = $adventurer;
                            $adventurer->getTreasure($destinationCell);
                            $actualCell->adventurer = null;
                        break;

                        case Orientation::South:
                            $destinationCell = $this->getCell($adventurerCoords[0], $adventurerCoords[1]+1);
                            if (!$destinationCell) {
                                throw new Exception ("An adventurer can not move out of the grid.");
                            }
                            
                            
                            if ($destinationCell->type === Types::Mountain) {
                                throw new Exception ("An adventurer can not move on a mountain.");
                            }
                            
                            $adventurer->moveForward();
                            $destinationCell->adventurer = $adventurer;
                            $adventurer->getTreasure($destinationCell);
                            $actualCell->adventurer = null;
                        break;

                        case Orientation::East:
                            $destinationCell = $this->getCell($adventurerCoords[0]-1, $adventurerCoords[1]);
                            if (!$destinationCell) {
                                throw new Exception ("An adventurer can not move out of the grid.");
                            }
                            
                            
                            if ($destinationCell->type === Types::Mountain) {
                                throw new Exception ("An adventurer can not move on a mountain.");
                            }
                            
                            $adventurer->moveForward();
                            $destinationCell->adventurer = $adventurer;
                            $adventurer->getTreasure($destinationCell);
                            $actualCell->adventurer = null;
                        break;
                    }
                break;
            }
        }

        $adventurerCoords = $adventurer->getCoords();
        $adventurer->moveForward();
    }
}
