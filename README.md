# Tic Tac Toe Game

This is a simple Tic Tac Toe game implemented using PHP for the backend and JavaScript (with jQuery) for the frontend. The game allows two players to take turns making moves and keeps track of the game state, including detecting the winner or a draw. Game results are stored in a MySQL database.

## Features

- Two players taking turns (Player X and Player O).
- Display of the current state of the board after each move.
- Detection and announcement of the winner or a draw.
- Handling of invalid moves gracefully.
- Use of appropriate functions and avoidance of global variables as much as possible.
- Storage of the results of each game, including the moves played and the outcome, in a MySQL database.

## Technologies Used

- **Backend:** PHP
- **Frontend:** HTML, CSS, JavaScript (jQuery)
- **Database:** MySQL

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/manish-patil-the-developer/tic-tac-toe.git
2. Database setup :
  ```bash
   CREATE DATABASE IF NOT EXISTS tic_tac_toe;
   
   USE tic_tac_toe;
   
   CREATE TABLE IF NOT EXISTS games (
       id INT AUTO_INCREMENT PRIMARY KEY,
       board_state TEXT NOT NULL,
       moves TEXT NOT NULL,
       winner CHAR(1),
       timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   );
