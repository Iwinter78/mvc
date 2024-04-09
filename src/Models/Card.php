<?php
namespace App\Models;

class Card 
{
    function __construct() {
        $this->suits = ['♠', '♣', '♥', '♦'];
        $this->values = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];
    }
}