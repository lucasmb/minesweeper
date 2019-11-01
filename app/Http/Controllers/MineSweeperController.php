<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Game\Cell;


class MineSweeperController extends Controller
{
    protected $board = null;
    protected $rows = 10;
    protected $cols = 10;
    protected $mines= 10;
    protected $game_over = false;
    protected $game_won = false;


    public function initGame() {

    }


    public function checkCell(Request $request)
    {


    }

    public function toggleFlag(Request $request)
    {

    }

    public function genereteBoard($r,$c,$m){
        $board= array();
        for ($x=0; $x<$r; $x++){
            for ($y=0; $y<$c; $y++){
                $board[$x][$y] = new Cell($x,$y,false,false);
            }
        }

        $this->setBoard($r,$c,$m, $board);
        $this->setMines($m);

        $this->completeCells();

        return true;
    }

    public function setBoard($r,$c,$m, $board): void {
        $this->rows=intval($r);
        $this->cols=intval($c);
        $this->mines=intval($m);
        $this->board=$board;
    }

    private function getBoard(){

        return $this->board;
    }
}
