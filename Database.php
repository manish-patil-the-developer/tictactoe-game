<?php
class Database {
    private $host;
    private $username;
    private $password;
    private $dbname;
    private $conn;

    public function __construct($host, $username, $password, $dbname) {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;

        // Create connection
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);
        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function insertGame($boardState, $moves, $winner) {
        $stmt = $this->conn->prepare("INSERT INTO games (board_state, moves, winner) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $boardState, $moves, $winner);
        $stmt->execute();
        $stmt->close();
    }

    // Additional method to fetch game data by ID
    public function getGameById($gameId) {
        $stmt = $this->conn->prepare("SELECT * FROM games WHERE id = ?");
        $stmt->bind_param("i", $gameId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $result;
    }

    // Add other database methods as needed
}

// command to create database - 

// CREATE DATABASE IF NOT EXISTS tic_tac_toe;

// USE tic_tac_toe;

// CREATE TABLE IF NOT EXISTS games (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     board_state TEXT NOT NULL,
//     moves TEXT NOT NULL,
//     winner CHAR(1),
//     timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
// );


