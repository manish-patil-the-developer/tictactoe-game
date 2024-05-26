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
    // print_r($moves[count($moves)-1]);
    $currentPlayerSymbol = isset($moves[count($moves)-1]) && isset($moves[count($moves)-1]['player']) === 'X' ? 'O' : 'X'; // Determine current player based on the last move

    $response = [
        'success' => true,
        'board' => $boardState,
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
