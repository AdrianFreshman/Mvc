<?php

namespace Controller\Card;

class BlackjackGame
{
    private Deck $deck;
    private array $playerCards = [];
    private array $dealerCards = [];
    private bool $playerTurn;
    private bool $gameOver;
    private int $playerChips;
    private int $dealerChips;
    private int $currentBet;
    private int $maxRounds = 5; // Play 5 rounds before resetting the game
    private int $roundsPlayed = 0; // Keep track of the number of rounds played
    private int $pot = 0; // The amount of chips that have been bet by both the player and the dealer
    private $winner;

    public function resetGame(string $winner): void
    {
    if ($winner === 'player') {
        $this->playerChips += $this->pot;
    } elseif ($winner === 'dealer') {
        $this->dealerChips += $this->pot;
    } else {
        $this->playerChips += $this->pot / 2;
        $this->dealerChips += $this->pot / 2;
    }
    
    $this->playerCards = [];
    $this->dealerCards = [];
    $this->playerTurn = true;
    $this->gameOver = false;
    $this->currentBet = 0;
    $this->pot = 0;
    $this->roundsPlayed++;
    if ($this->roundsPlayed >= $this->maxRounds) {
        $this->playerChips = 100;
        $this->dealerChips = 100;
        $this->roundsPlayed = 0;
    }
    $this->winner = ''; // Reset the winner property
    
    if ($this->playerChips == 0 || $this->dealerChips == 0 || $this->dealerChips < 0) {
        $this->gameOver = true;
    }
    }


    public function getPlayerCards(): array
    {
        return $this->playerCards;
    }

    public function getDealerCards(): array
    {
        return $this->dealerCards;
    }

    public function getPlayerChips(): int
    {
        return $this->playerChips;
    }

    public function getDealerChips(): int
    {
        return $this->dealerChips;
    }

    public function getCurrentBet(): int
    {
        return $this->currentBet;
    }

    public function __construct(int $startingChips = 100)
    {
        $this->deck = new Deck();
        $this->playerCards = array();
        $this->dealerCards = array();
        $this->playerTurn = true;
        $this->gameOver = false;
        $this->playerChips = $startingChips;
        $this->dealerChips = $startingChips;
        $this->currentBet = 0;
    }

    public function startGame(): void
    {

        // Shuffle the deck and deal two cards to the player and two cards to the dealer
        $this->deck->shuffle();
        $this->playerCards[] = $this->deck->dealCard();
        $this->dealerCards[] = $this->deck->dealCard();
        $this->playerCards[] = $this->deck->dealCard();
        $this->dealerCards[] = $this->deck->dealCard();

        // Check if the player has a blackjack and declare the winner if they do
        if ($this->getPlayerScore() === 21) {
            $this->gameOver = true;
            $this->winner = 'player';
            return;
        }


        // Set current bet to 0
        $this->currentBet = 0;
    }

    public function calculateScore(array $cards): int
    {
        $score = 0;
        $aceCount = 0;
        foreach ($cards as $card) {
            $value = $card->getValue();
            if ($value === 'King' || $value === 'Queen' || $value === 'Knight') {
                $score += 10;
            }
            if ($value === 'Ace') {
                $score += 11;
                $aceCount++;
            }
            if (is_numeric($value)) {
                $score += $value;
            }
        }
        // Handle the case where there are aces and the score is over 21
        while ($score > 21 && $aceCount > 0) {
            $score -= 10;
            $aceCount--;
        }
        return $score;
    }

    public function getPlayerScore(): int
    {
        return $this->calculateScore($this->playerCards);
    }

    
    public function getDealerScore(): int
    {
        // Only show the first card of the dealer
        $dealerCards = array_slice($this->dealerCards, 1);
        return $this->calculateScore($dealerCards);
    }

    public function isPlayerTurn(): bool
    {
        return $this->playerTurn;
    }

    public function isGameOver(): bool
    {
        return $this->gameOver;
    }

    public function placeBet(int $amount)
    {

        $this->currentBet = $amount;
        $this->playerChips -= $amount;
        $this->dealerChips -= $amount;
        $this->pot = $amount * 2;
    }

        private function playerWins(): void
        {
            $this->playerChips += $this->currentBet * 2; // Add the current bet to the player's chips
            $this->gameOver = true;

        }

        private function dealerWins(): void
        {
            $this->dealerChips += $this->currentBet * 2; // Add the current bet to the dealer's chips
            $this->gameOver = true;

        }

        private function tie(): void
        {
            $this->gameOver = true;

        }

    public function playerHit(): void
    {
        if (!$this->playerTurn || $this->gameOver) {
            return;
        }

        $this->playerCards[] = $this->deck->dealCard();
        if ($this->getPlayerScore() > 21) {
            $this->dealerWins();
        }

        // Check if the player has a blackjack and declare the winner if they do
        if ($this->getPlayerScore() === 21) {
            $this->gameOver = true;
            $this->winner = 'player';
            return;
        }
    }

    public function playerStand(): void
    {
        if (!$this->playerTurn || $this->gameOver) {
            return;
        }

        $this->playerTurn = false;

        while ($this->getDealerScore() < 17) {
            $this->dealerCards[] = $this->deck->dealCard();
        }

        if ($this->getDealerScore() > 21 || $this->getDealerScore() < $this->getPlayerScore()) {
            $this->playerWins();
            return;
        }
        
        if ($this->getDealerScore() > $this->getPlayerScore()) {
            $this->dealerWins();
            return;
        }
        
        $this->tie();
    }

    public function dealerPlay(): void
    {
        while ($this->getDealerScore() < 17) {
            $this->dealerCards[] = $this->deck->dealCard();
        }
        
        if ($this->getDealerScore() > 21 || $this->getDealerScore() < $this->getPlayerScore()) {
            $this->playerChips += $this->currentBet * 2;
            $this->gameOver = true;
            return;
        }
        
        if ($this->getDealerScore() > $this->getPlayerScore()) {
            $this->dealerChips += $this->currentBet * 2;
        } else {
            $this->playerChips += $this->currentBet;
        }
        
        $this->gameOver = true;
    }

    public function getWinner(): ?string
    {
        if (!$this->gameOver) {
            return null;
        }
        
        $playerScore = $this->getPlayerScore();
        $dealerScore = $this->getDealerScore();
        
        if ($playerScore > 21) {
            return 'dealer';
        }
        
        if ($dealerScore > 21) {
            return 'player';
        }
        
        if ($playerScore == 21) {
            return 'player';
        }
        
        if ($playerScore > $dealerScore) {
            return 'player';
        }
        
        if ($dealerScore > $playerScore) {
            return 'dealer';
        }
        return "It's a tie!";
    }
}
