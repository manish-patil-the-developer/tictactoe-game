<?php
class Board {
    private $cells;
    private $winning_move;

    public function __construct() {
        $this->cells = [
            ['', '', ''],
            ['', '', ''],
            ['', '', '']
        ];
        $this->winning_move = [];
    }

    public function makeMove($row, $col, $symbol) {
        if ($this->cells[$row][$col] === '') {
            $this->cells[$row][$col] = $symbol;
            return true;
        }
        return false;
    }

    public function checkWinner() {
        // Check rows
        for ($i = 0; $i < 3; $i++) {
            if ($this->cells[$i][0] && $this->cells[$i][0] === $this->cells[$i][1] && $this->cells[$i][0] === $this->cells[$i][2]) {
                $this->winning_move = [$i.'_0', $i.'_1', $i.'_2'];
                return $this->cells[$i][0];
            }
        }
        // Check columns
        for ($i = 0; $i < 3; $i++) {
            if ($this->cells[0][$i] && $this->cells[0][$i] === $this->cells[1][$i] && $this->cells[0][$i] === $this->cells[2][$i]) {
                $this->winning_move = ['0_'.$i, '1_'.$i, '2_'.$i];
                return $this->cells[0][$i];
            }
        }
        // Check diagonals
        if ($this->cells[0][0] && $this->cells[0][0] === $this->cells[1][1] && $this->cells[0][0] === $this->cells[2][2]) {
            $this->winning_move = ['0_0', '1_1', '2_2'];
            return $this->cells[0][0];
        }
        if ($this->cells[0][2] && $this->cells[0][2] === $this->cells[1][1] && $this->cells[0][2] === $this->cells[2][0]) {
            $this->winning_move = ['0_2', '1_1', '2_0'];
            return $this->cells[0][2];
        }
        return null;
    }

    public function isBoardFull() {
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                if ($this->cells[$i][$j] === '') {
                    return false;
                }
            }
        }
        return true;
    }

    public function getCells() {
        return $this->cells;
    }

    public function setCells($cells) {
        $this->cells = $cells;
    }

    public function getWinningMove() {
        return $this->winning_move;
    }

}
