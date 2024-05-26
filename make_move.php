<?php
require_once 'database.php';
require_once 'player.php';
require_once 'game.php';

// Retrieve move parameters from POST data
$row = $_POST['row'];
$col = $_POST['col'];
$currentPlayerSymbol = $_POST['currentPlayer'];

// Initialize game
$playerX = new Player('X');
$playerO = new Player('O');
$game = new Game($playerX, $playerO);

// Fetch the latest game state from the database
$database = new Database('localhost', 'root', '', 'tic_tac_toe');
$gameData = $database->getLatestGame();

if ($gameData) {
    $game->loadGameState(unserialize($gameData['board_state']), unserialize($gameData['moves']), $currentPlayerSymbol);
}

// Make the move
$result = $game->makeMove($row, $col);

// Check game status
$status = $game->checkGameStatus();
$winner = $game->checkWinner();

// Save the updated game state to the database
$boardState = serialize($game->getBoard()->getCells());
$moves = serialize($game->getMoves());
$database->insertGame($boardState, $moves, $winner);

// Return JSON response
$response = [
    'success' => $result,
    'status' => $status,
    'currentPlayer' => $game->getCurrentPlayer()->getSymbol(),
    'board' => $game->getBoard()->getCells()
];

header('Content-Type: application/json');
echo json_encode($response);
?>
