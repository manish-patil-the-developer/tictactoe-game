<?php
require_once 'Database.php';

class TicTacToeModel {
    private $board;
    private $currentPlayer;
    private $db;

    public function __construct(Database $db) {
        $this->board = [
            ['', '', ''],
            ['', '', ''],
            ['', '', '']
        ];
        $this->currentPlayer = 'X'; // Start with player X
        $this->db = $db;
    }

    public function makeMove($row, $col) {
        // Validate the move
        if ($this->board[$row][$col] !== '') {
            return false; // Move is invalid
        }

        // Update the board with the player's move
        $this->board[$row][$col] = $this->currentPlayer;

        // Check for a winner or draw
        $winner = $this->checkWinner();
        $isDraw = $this->isBoardFull() && !$winner;

        // Save the game state to the database
        $this->saveGameState();

        // Switch to the next player
        $this->currentPlayer = ($this->currentPlayer === 'X') ? 'O' : 'X';

        return true; // Move successful
    }

    private function checkWinner() {
        // Check rows
        for ($i = 0; $i < 3; $i++) {
            if ($this->board[$i][0] !== '' && $this->board[$i][0] === $this->board[$i][1] && $this->board[$i][0] === $this->board[$i][2]) {
                return $this->board[$i][0]; // Return the winning player
            }
        }
    
        // Check columns
        for ($i = 0; $i < 3; $i++) {
            if ($this->board[0][$i] !== '' && $this->board[0][$i] === $this->board[1][$i] && $this->board[0][$i] === $this->board[2][$i]) {
                return $this->board[0][$i]; // Return the winning player
            }
        }
    
        // Check diagonals
        if ($this->board[0][0] !== '' && $this->board[0][0] === $this->board[1][1] && $this->board[0][0] === $this->board[2][2]) {
            return $this->board[0][0]; // Return the winning player
        }
        if ($this->board[0][2] !== '' && $this->board[0][2] === $this->board[1][1] && $this->board[0][2] === $this->board[2][0]) {
            return $this->board[0][2]; // Return the winning player
        }
    
        // If no winner, return null
        return null;
    }

    private function isBoardFull() {
        foreach ($this->board as $row) {
            foreach ($row as $cell) {
                if ($cell === '') {
                    return false; // If any cell is empty, the board is not full
                }
            }
        }
        return true; // If no empty cells are found, the board is full
    }    
    
    private function saveGameState() {
        // Serialize the board and moves
        $boardState = serialize($this->board);
        $moves = ''; // Implement logic to serialize moves
        $winner = $this->checkWinner(); // Check winner again

        // Insert the game state into the database
        $this->db->insertGame($boardState, $moves, $winner);
    }

    // Additional method to fetch game data from the database
    public function getGameById($gameId) {
        return $this->db->getGameById($gameId);
    }

    // Add other methods as needed
}
?>
