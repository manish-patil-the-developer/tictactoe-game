<?php

class Player {
    private $symbol;

    public function __construct($symbol) {
        $this->symbol = $symbol;
    }

    public function getSymbol() {
        return $this->symbol;
    }
}
