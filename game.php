<?php
require_once 'player.php';
require_once 'board.php';

class Game {
    private $playerX;
    private $playerO;
    private $currentPlayer;
    private $board;
    private $moves;

    public function __construct($playerX, $playerO) {
        $this->playerX = $playerX;
        $this->playerO = $playerO;
        $this->currentPlayer = $playerX;
        $this->board = new Board();
        $this->moves = [];
    }

    public function makeMove($row, $col) {
        if ($this->board->makeMove($row, $col, $this->currentPlayer->getSymbol())) {
            $this->moves[] = ['player' => $this->currentPlayer->getSymbol(), 'row' => $row, 'col' => $col];
            $this->switchPlayer();
            return true;
        }
        return false;
    }

    public function switchPlayer() {
        $this->currentPlayer = $this->currentPlayer === $this->playerX ? $this->playerO : $this->playerX;
    }

    public function checkGameStatus() {
        $winner = $this->board->checkWinner();
        if ($winner) {
            return $winner;
        } elseif ($this->board->isBoardFull()) {
            return false;
        } else {
            return null; // Game still ongoing
        }
    }

    public function checkWinner() {
        return $this->board->checkWinner();
    }

    public function getCurrentPlayer() {
        return $this->currentPlayer;
    }

    public function getBoard() {
        return $this->board;
    }

    public function getMoves() {
        return $this->moves;
    }

    public function loadGameState($boardState, $moves, $currentPlayerSymbol) {
        $this->board->setCells($boardState);
        $this->moves = $moves;
        $this->currentPlayer = $currentPlayerSymbol === 'X' ? $this->playerX : $this->playerO;
    }

    public function getWinningMove() {
        return $this->board->getWinningMove();
    }

}
