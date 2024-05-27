<?php
require_once 'database.php';
require_once 'player.php';
require_once 'game.php';

// Fetch the latest game state from the database
$database = new Database('localhost', 'root', '', 'tic_tac_toe');
$gameData = $database->getLatestGame();

$response = [];
if ($gameData) {
    $boardState = unserialize($gameData['board_state']);
    $moves = unserialize($gameData['moves']);
    $currentPlayerSymbol = isset($moves[count($moves)-1]) && isset($moves[count($moves)-1]['player']) && $moves[count($moves)-1]['player'] === 'X' ? 'O' : 'X'; // Determine current player based on the last move

    $response = [
        'success' => true,
        'board' => $boardState,
        'resetBoard' => isset($gameData['winner']) && !empty($gameData['winner']) ? True : false ,
        'currentPlayer' => $currentPlayerSymbol
    ];
} else {
    $response = [
        'success' => false,
        'message' => 'No game state found.'
    ];
}
header('Content-Type: application/json');
echo json_encode($response);
