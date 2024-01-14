<?php

namespace App;

enum Moves: string
{
    case Forward = 'A';
    case TurnLeft = 'G';
    case TurnRight = 'D';
}