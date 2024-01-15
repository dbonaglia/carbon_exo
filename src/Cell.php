<?php

namespace App;

use App\Types;
use Exception;

class Cell
{
    public string $visual;
    private Colors $color = Colors::lime;
    public ?Adventurer $adventurer = null;

    public function __construct(
        public Types $type,
        public int $x,
        public int $y,
        public int $treasures = 0
    ) {
    }

    public function setTreasures(int $treasures): void
    {
        $this->treasures = $treasures;
    }

    public function setType(Types $type, int $treasures = 0): self
    {
        $this->type = $type;
        
        switch ($this->type) {
            case $this->type::Plain:
                $this->color = Colors::lime;
                $this->treasures = 0;
            break;

            case $this->type::Mountain:
                $this->color = Colors::green;
                $this->treasures = 0;
            break;

            case $this->type::Treasure:
                if ($treasures <= 0) {
                    throw new Exception('You cannot set a treasure cell without a minimum of 1 treasure.');
                }
                $this->color = Colors::olive;
                $this->treasures = $treasures;
            break;
        }

        return $this;
    }

    public function render()
    {
        if ($this->adventurer) {
            $name = substr($this->adventurer->name, 0, 1);
            echo "<div class='box' style='background-color:" . $this->color->value . ";'>" . $name . "</div>";
            
            return;
        }

        echo "<div class='box' style='background-color:" . $this->color->value . ";'></div>";
    }
}
