<?php

namespace Controller\Card;

// Card interface
interface Card
{
    public function getValue();
    public function getSuit();
}

class BaseCard implements Card
{
    private $value;
    private $suit;

    public function __construct($value, $suit)
    {
        $this->value = $value;
        $this->suit = $suit;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getSuit()
    {
        return $this->suit;
    }

    public function getImagePath()
    {
        // Define an array of suits and their corresponding image file prefix
        $suits = array(
        'Spades' => 'spade',
        'Hearts' => 'heart',
        'Diamonds' => 'daimond',
        'Clubs' => 'clove'
        );

        // Construct the image file name based on the card's suit and value
        $imageName = $suits[$this->suit] . ucfirst($this->value) . '.png';

        $baseUrl = 'https://www.student.bth.se/~adde22/dbwebb-kurser/mvc/me/report/public/';

        // Return the full image path relative to the web root directory
        return $baseUrl . '/img/' . $imageName;
    }
}


class Deck
{
    private $cards;

    public function __construct()
    {
        $this->cards = array();
        // Add all 52 cards to the deck
        $suits = array('Spades', 'Hearts', 'Diamonds', 'Clubs');
        $values = array(2, 3, 4, 5, 6, 7, 8, 9, 10, 'King', 'Queen', 'Knight','Ace');
        foreach ($suits as $suit) {
            foreach ($values as $value) {
                $this->cards[] = new BaseCard($value, $suit);
            }
        }
    }

    public function shuffle()
    {
        shuffle($this->cards);
        return $this->cards; // Return the shuffled array
    }

    public function dealCard()
    {
        return array_pop($this->cards);
    }

    public function getAllCards()
    {
        return $this->cards;
    }

    public function countCards()
    {
        return count($this->cards);
    }
}
