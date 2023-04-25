<?php

namespace Controller\Card;

// Card interface
interface Card
{
    public function getValue(): mixed;
    public function getSuit(): mixed;
}

class BaseCard implements Card
{
    private int|string $value;
    private string $suit;

    public function __construct(int|string $value, string $suit)
    {
        $this->value = $value;
        $this->suit = $suit;
    }

    public function getValue(): int|string
    {
        return $this->value;
    }

    public function getSuit(): string
    {
        return $this->suit;
    }

    public function getImagePath(): string
    {
        // Define an array of suits and their corresponding image file prefix
        $suits = array(
            'Spades' => 'spade',
            'Hearts' => 'heart',
            'Diamonds' => 'daimond',
            'Clubs' => 'clove'
        );

        // Construct the image file name based on the card's suit and value
        $imageName = $suits[$this->suit] . ucfirst(strval($this->value)) . '.png';

        $baseUrl = 'https://www.student.bth.se/~adde22/dbwebb-kurser/mvc/me/report/public/';

        // Return the full image path relative to the web root directory
        return $baseUrl . '/img/' . $imageName;
    }
}


class Deck
{
    /** @var BaseCard[] */
    private array $cards;

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

   /**
     * @return Card[]
     */
    public function shuffle(): array
    {
        shuffle($this->cards);
        return $this->cards; // Return the shuffled array
    }

    /**
     * @return BaseCard|null
     */
    public function dealCard(): ?BaseCard
    {
        if (empty($this->cards)) {
            return null; // If the deck is empty, return null
        }
        return array_pop($this->cards);
    }

    /**
     * @return array<BaseCard>
     */
    public function getAllCards(): array
    {
        return $this->cards;
    }

    public function countCards(): int
    {
        return count($this->cards);
    }
}
