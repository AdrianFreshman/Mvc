<?php

namespace Controller\Card;

class TexasHoldem {

    private array $players;
    private Deck $deck;
    private int $pot;
    private int $currentBet;
    private int $highestBet;
    private int $currentPlayerIndex;
    private array $communityCards = []; // Define the communityCards property

    public function getCurrentPlayerIndex(): int {
        return $this->currentPlayerIndex;
    }

    public function getPlayers(): array {
        return $this->players;
    }

    public function getCommunityCards(): array {
        return $this->communityCards;
    }

    public function __construct() {
        $this->players = array(
            new Player('Player', 1),
            new AIPlayer('AI',2)
        );
        $this->deck = new Deck();
        $this->currentBet = 0;
        $this->highestBet = 2;
        $this->currentPlayerIndex = 0;
    }

     public function play() {
        if (!isset($this->pot)) {
            $this->pot = 0;
        }

         // Shuffle the deck before dealing the cards
        $this->deck->shuffle();

        // Deal 2 cards to each player
        foreach ($this->players as $player) {
            $card1 = $this->deck->dealCard();
            $card2 = $this->deck->dealCard();
            $player->addCards($card1, $card2);
            $card1ImagePath = $card1->getImagePath();
            $card2ImagePath = $card2->getImagePath();
        }

        // Set the small blind
        $this->players[0]->bet(1);
        $this->pot += 1;

        // Set the big blind
        $this->players[1]->bet(2);
        $this->pot += 2;
        $this->currentBet = 2;

        // Start the first round of betting
        $this->bettingRound();

        // Deal the flop (3 cards)
        $this->communityCards[] = $this->deck->dealCard();
        $this->communityCards[] = $this->deck->dealCard();
        $this->communityCards[] = $this->deck->dealCard();

        foreach ($this->communityCards as $communityCard) {
            $communityCardImagePath = $communityCard->getImagePath();
        }

        // Start the second round of betting
        $this->bettingRound();

        // Deal the turn (4th card)
        $this->communityCards[] = $this->deck->dealCard();

        $turnCardImagePath = end($this->communityCards)->getImagePath();

        // Start the third round of betting
        $this->bettingRound();

        // Deal the river (5th card)
        $this->communityCards[] = $this->deck->dealCard();

        $riverCardImagePath = end($this->communityCards)->getImagePath();

        // Start the final round of betting
        $this->bettingRound();

        // // Determine the winner
        // $winningPlayer = $this->determineWinner();
        // $winningPlayer->winPot($this->pot);

        // // Reset the game state
        // $this->reset();
    }

    


    private function bettingRound() {
    $roundComplete = false;
    $numPlayers = count($this->players);
    $lastRaiseIndex = -1;
    $numPlayersLeft = $numPlayers;

     while (!$roundComplete) {
            $currentPlayer = $this->players[$this->currentPlayerIndex];

            if ($currentPlayer instanceof AIPlayer) {
                $betAmount = 1;
            } else {
                $betAmount = 2;
            }

            // Place the bet
            $currentPlayer->bet($betAmount);
            $this->pot += $betAmount;
            $this->currentBet = $betAmount;

            // Update the current highest bet
            if ($this->currentBet > $this->highestBet) {
                $this->highestBet = $this->currentBet;
                $lastRaiseIndex = $this->currentPlayerIndex;
            }

            // Move to the next player
            $this->currentPlayerIndex++;
            if ($this->currentPlayerIndex >= $numPlayers) {
                $this->currentPlayerIndex = 0;
            }

            // Check if the round is complete
            $numPlayersLeft = 0;
            foreach ($this->players as $player) {
                if ($player->getChips() > 0 && !$player->hasFolded()) {
                    $numPlayersLeft++;
                }
        }

        // If only one player is left, end the round
        if ($numPlayersLeft == 1) {
            $roundComplete = true;
        }

        // If everyone has checked or called the current highest bet, end the round
        if ($lastRaiseIndex == $this->currentPlayerIndex || $this->highestBet == 0) {
            $roundComplete = true;
        }
    }
}

}

class Player {
    private $id;
    private string $name;
    private array $cards;
    private int $chips;
    private int $currentBet;
    private bool $hasFolded = false;


    public function __construct(string $name, int $id) {
    $this->name = $name;
    $this->cards = [];
    $this->chips = 100;
    $this->currentBet = 0;
    $this->id = $id;
    }


    public function getCards(): array { // add getCards() method
        return $this->cards;
    }

    public function getId() {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function fold()
    {
        $this->hasFolded = true;
    }

    public function hasFolded()
    {
        return $this->hasFolded;
    }

    public function addCards(BaseCard ...$cards) {
        foreach ($cards as $card) {
            $this->cards[] = $card;
        }
    }

    public function bet(int $amount) {
        $this->chips -= $amount;
        $this->currentBet += $amount;
    }

    public function getChips() {
        return $this->chips;
    }

    public function getCurrentBet() {
        return $this->currentBet;
    }

    public function reset() {
        $this->cards = array();
        $this->currentBet = 0;
    }

}

    class AIPlayer extends Player {
        private $cards;


    }
