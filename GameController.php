<?php
require_once 'TicTacToeModel.php';

class GameController {
    private $model;

    public function __construct(TicTacToeModel $model) {
        $this->model = $model;
    }

    public function makeMove($row, $col) {
        return $this->model->makeMove($row, $col);
    }

    // Additional method to fetch game data
    public function getGameById($gameId) {
        return $this->model->getGameById($gameId);
    }

    // Add other controller methods as needed
}
?>
