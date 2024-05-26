<?php

require_once 'player.php';
require_once 'game.php';

// Create players
$playerX = new Player('X');
$playerO = new Player('O');

// Create game
$game = new Game($playerX, $playerO);

// Example moves
$game->makeMove(0, 0); // Player X makes a move at (0, 0)
$game->switchPlayer(); // Switch to player O
$game->makeMove(1, 1); // Player O makes a
