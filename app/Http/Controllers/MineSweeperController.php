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

    public function __construct()
    {
        $this->getBoard();
    }

    public function initGame(Request $request) {
        //remove cached board
        Cache::forget('board');

        $r = intval($request->query('rows'));
        $c = intval($request->query('cols'));
        $m = intval($request->query('mines'));

        if($r<1 || $c<1 ||  $m<1)
            throw new \Exception('Select value greater than 1');

        if($this->genereteBoard($r,$c,$m))
            return response()->json(array('board'=>$this->board), 200 );
    }


    public function checkCell(Request $request)
    {
        $x = $request->input('x');
        $y = $request->input('y');
        $auto = array();
        // $this->getBoard();

        // Game over check
        if ($this->game_over)
        {
            return response()->json(array('game_over'=>$this->game_over), 201 );
        }

        // Check valid position
        // Add mines?

        // Get the board Cell
        $clickedCell = $this->getCell($x, $y);
        if(!is_null($clickedCell)){
            // Check if cell is revealed or flagged
            if ($clickedCell->isRevealed() || $clickedCell->isFlagged())
            {
                return response()->json(false, 204 );
            }else
            {
                if($clickedCell->reveal($this->board, $auto) ){
                    $this->game_over = true;
                    return response()->json(array('game_over'=>$this->game_over), 201 );
                }
                $this->board[$x][$y] = $clickedCell;
            }
        }

        //update board
        $this->updateBoard($this->board);

        if(!empty($auto) && count($auto)>1)
            return response()->json(array('autoreveal'=>$auto, 'celldata'=>null), 200 );

        return response()->json(array('autoreveal'=>null, 'celldata'=>$clickedCell), 200 );

    }

    public function toggleFlag(Request $request)
    {
        $x = $request->input('x');
        $y = $request->input('y');
        // Get the board Cell
        $clickedCell = $this->getCell($x, $y);

        if(!is_null($clickedCell)){
            // Check if cell is revealed
            if ($clickedCell->isRevealed())
            {
                return response()->json(false, 204 );
            }else{
                $clickedCell->toggleFlag();
                $this->board[$x][$y] = $clickedCell;
            }
        }

        $this->updateBoard($this->board);
        return response()->json($clickedCell, 200 );
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

    public function setMines($mines){
        $m = 0;
        $board = $this->board;

        if($mines > ($this->rows * $this->cols))
            throw new \Exception('bombs are greater than the grid cells');

        $count=0;
        while($m<$mines) {
            $count++;
            $positions = $this->getRandomPosition();
            if (is_object($board[$positions[0]][$positions[1]]) && !$board[$positions[0]][$positions[1]]->hasBomb() )
            {
                $board[$positions[0]][$positions[1]]->isBomb = true;
                $board[$positions[0]][$positions[1]]->mineTotals = -1;
                $m++;
            }
        }

        $this->updateBoard($this->board);
        return true;
    }

    public function completeCells(): bool {
        for ($x=0; $x<=$this->rows-1; $x++){
            for ($y=0; $y<=$this->cols-1; $y++){
                $currentCell= $this->getCell($x,$y);
                $aj=array();
                foreach($this->countMines($x,$y) as $adj){
                    if($adj->hasBomb())
                        $currentCell->mineTotals++;
                }
            }
        }

        $this->updateBoard($this->board);
        return true;
    }

    public function countMines($x,$y) : array {
        $adj = array();
        for ($xn=($x-1) ; $xn<=($x+1); $xn++){
            for ($yn=($y-1); $yn<=($y+1); $yn++){
                if ($x== $xn && $y==$yn)
                    continue;

                if($this->validPosition($xn,$yn) ){
                    array_push($adj, $this->getCell($xn,$yn) );
                }
            }
        }

        return $adj;
    }

    public function validPosition($x,$y){
        if ( ( !is_int($x) && $x< 0 ) || !is_int($y) && $y< 0)
            return false;
        if(!isset($this->board[$x][$y]))
            return false;

        return true;
    }

    public function getCell($x, $y) : Cell {
        return $this->board[$x][$y];
    }

    public function getRandomPosition()
    {
        $posx=rand(0,($this->rows-1));
        $posy=rand(0,($this->cols-1));
        return array($posx, $posy);
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

    private function updateBoard($board)
    {
        $this->board = $board;
        Cache::put('board', $board, now()->addMinutes(60));
    }
}
