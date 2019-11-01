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

    /**
     * reveal the clicked cell and collect array of cells for autoreveal.
     **/
    public function reveal(& $board, &$auto){
        $this->revealed = true;

        if($this->hasBomb())
            return true;

        //collect adjacents for autoreveal
        $auto[]= array($this->x, $this->y);
        if($this->mineTotals == 0){
            //check all the adjacents for near mines
            $this->cellAdjacents($this->x, $this->y, $board, $auto);
        }else{
            return false;
        }
    }

    /**
     * Walk over adjacents cells.
     **/
    public function cellAdjacents($x,$y, $board, & $auto) : bool {
        for ($xn=-1; $xn<=1; $xn++){
            for ($yn=-1; $yn<=1; $yn++) {
                $i = $x+$xn; $j = $y+$yn;
                if ( ( $i >= 0 && $j >= 0) && isset($board[$i][$j]) ){
                    if (! $board[$i][$j]->hasBomb() && !$board[$i][$j]->isRevealed() && !$board[$i][$j]->isFlagged())
                        $board[$i][$j]->reveal($board, $auto);
                }else{
                    return false;
                }
            }
        }
        return true;
    }

    public function isRevealed(){
        return $this->revealed;
    }

    public function isFlagged(){
        return $this->flagged;
    }

    public function hasBomb(){
        return $this->isBomb;
    }

    public function toggleFlag()
    {
        $this->flagged = ! $this->flagged;
    }

    public function getTotalMines()
    {
        return $this->mineTotals;
    }
}
