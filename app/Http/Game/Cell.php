<?php


namespace App\Http\Game;


class Cell
{
    public $x;
    public $y;
    public $mineTotals;
    public $isBomb = false;
    public $revealed = false;
    public $flagged = false;

    public function __construct($xPos, $yPos){
        $this->x = $xPos;
        $this->y = $yPos;
        $this->isBomb = false;
        $this->revealed = false;
        $this->flagged = false;
        $this->mineTotals = 0;
    }
}
