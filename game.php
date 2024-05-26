<?php

// Handle CORS (Cross-Origin Resource Sharing) for AJAX requests
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(array("error" => "Method Not Allowed"));
    exit();
}

// Parse the incoming JSON data
$requestData = json_decode(file_get_contents("php://input"), true);

// Check if required data is provided
if (!isset($requestData["action"])) {
    http_response_code(400);
    echo json_encode(array("error" => "No action specified"));
    exit();
}

$action = $requestData["action"];

// Perform action based on the request
switch ($action) {
    case "makeMove":
        makeMove($requestData);
        break;
    case "resetGame":
        resetGame();
        break;
    default:
        http_response_code(400);
        echo json_encode(array("error" => "Invalid action"));
}

// Function to make a move
function makeMove($requestData) {
    // Check if required data is provided
    if (!isset($requestData["board"]) || !isset($requestData["row"]) || !isset($requestData["col"]) || !isset($requestData["currentPlayer"])) {
        http_response_code(400);
        echo json_encode(array("error" => "Incomplete data provided"));
        exit();
    }

    // Extract data from the request
    $board = $requestData["board"];
    $row = $requestData["row"];
    $col = $requestData["col"];
    $currentPlayer = $requestData["currentPlayer"];

    // Validate the move
    if ($row < 0 || $row > 2 || $col < 0 || $col > 2 || $board[$row][$col] !== '') {
        http_response_code(400);
        echo json_encode(array("error" => "Invalid move"));
        exit();
    }

    // Update the board with the player's move
    $board[$row][$col] = $currentPlayer;

    // Check for a winner or draw
    $winner = checkWinner($board);
    $isDraw = isBoardFull($board) && !$winner;

    // Prepare response
    $response = array(
        "status" => "success",
        "message" => "Move successful",
        "board" => $board,
        "winner" => $winner,
        "isDraw" => $isDraw
    );

    // Send JSON response
    echo json_encode($response);
}

// Function to reset the game
function resetGame() {
    // Initialize an empty board
    $board = [
        ['', '', ''],
        ['', '', ''],
        ['', '', '']
    ];

    // Prepare response
    $response = array(
        "status" => "success",
        "message" => "Game reset successful",
        "board" => $board
    );

    // Send JSON response
    echo json_encode($response);
}

// Function to check for a winner
function checkWinner($board) {
    // Check rows
    for ($i = 0; $i < 3; $i++) {
        if ($board[$i][0] !== '' && $board[$i][0] === $board[$i][1] && $board[$i][0] === $board[$i][2]) {
            return $board[$i][0]; // Return the winning player
        }
    }

    // Check columns
    for ($i = 0; $i < 3; $i++) {
        if ($board[0][$i] !== '' && $board[0][$i] === $board[1][$i] && $board[0][$i] === $board[2][$i]) {
            return $board[0][$i]; // Return the winning player
        }
    }

    // Check diagonals
    if ($board[0][0] !== '' && $board[0][0] === $board[1][1] && $board[0][0] === $board[2][2]) {
        return $board[0][0]; // Return the winning player
    }
    if ($board[0][2] !== '' && $board[0][2] === $board[1][1] && $board[0][2] === $board[2][0]) {
        return $board[0][2]; // Return the winning player
    }

    // If no winner, return null
    return null;
}

// Function to check if the board is full (draw)
function isBoardFull($board) {
    foreach ($board as $row) {
        foreach ($row as $cell) {
            if ($cell === '') {
                return false; // If any cell is empty, the board is not full
            }
        }
    }
    return true; // If no empty cells are found, the board is full
}

?>
