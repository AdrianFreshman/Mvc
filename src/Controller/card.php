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

    /**
     * Create a new instance of a card with a given value and suit.
     *
     * @param int|string $value The numerical or string value of the card.
     * @param string $suit The suit of the card.
     */
    public function __construct(int|string $value, string $suit)
    {
        $this->value = $value;
        $this->suit = $suit;
    }

    /**
     * Get the numerical or string value of the card.
     *
     * @return mixed The value of the card.
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * Get the suit of the card.
     *
     * @return mixed The suit of the card.
     */
    public function getSuit(): mixed
    {
        return $this->suit;
    }


    /**
     * Get the path to the image file for the card.
     *
     * @return string The path to the image file for the card.
     */
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

    /**
     * Create a new deck of cards with all 52 cards.
     */
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
     * Shuffle the deck of cards.
     *
     * @return Card[] The shuffled array of cards.
     */
    public function shuffle(): array
    {
        shuffle($this->cards);
        return $this->cards; // Return the shuffled array
    }

    /**
     * Deal a card from the top of the deck.
     *
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
     * Deal All cards from the deck
     *
     * @return array<BaseCard>
     */
    public function getAllCards(): array
    {
        return $this->cards;
    }

    /**
     * Returns the number of cards in the deck.
     *
     * @return int The number of cards in the deck.
     */
    public function countCards(): int
    {
        return count($this->cards);
    }

    /**
     * Deals a card from the deck at the specified index.
     *
     * @param int $index The index of the card to deal.
     * @return BaseCard|null The card dealt or null if the deck is empty or the index is out of bounds.
     */
    public function dealCardManually(int $index): ?BaseCard
    {
        if (empty($this->cards) || $index < 0 || $index >= count($this->cards)) {
            return null; // If the deck is empty or the index is out of bounds, return null
        }
        return array_splice($this->cards, $index, 1)[0];
    }

    /**
     * Deals specific card.
     *
     * @param int|string $value The value of the card to search for
     * @param string $suit The suit of the card to search for
     * @return BaseCard|null The found card or null if not found
     */
    public function dealSpecificCard($value, string $suit): ?BaseCard
    {
        foreach ($this->cards as $index => $card) {
            if ($card->getValue() === $value && $card->getSuit() === $suit) {
                return $this->dealCardManually($index); // Use the existing function to deal the card
            }
        }
        return null; // Card not found
    }
}
