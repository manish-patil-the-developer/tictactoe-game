<?php
require_once 'database.php';

// Reset game state in the database
$database = new Database('localhost', 'root', '', 'tic_tac_toe');
$database->insertGame(serialize([['', '', ''], ['', '', ''], ['', '', '']]), serialize([]), null);

$response = [
    'success' => true
];

header('Content-Type: application/json');
echo json_encode($response);
?>
