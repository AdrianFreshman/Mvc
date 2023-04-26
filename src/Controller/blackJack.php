<?php

namespace Controller\Card;

class BlackjackGame
{
    private Deck $deck;
    private array $playerCards;
    private array $dealerCards;
    private bool $playerTurn;
    private bool $gameOver;
    private int $playerChips;
    private int $dealerChips;
    private int $currentBet;
    private int $maxRounds = 5; // Play 5 rounds before resetting the game
    private int $roundsPlayed = 0; // Keep track of the number of rounds played
    private int $pot = 0; // The amount of chips that have been bet by both the player and the dealer


    public function updateChips(string $winner)
    {
        if ($winner === 'player') {
            $this->playerChips += $this->pot;
        } elseif ($winner === 'dealer') {
            $this->dealerChips += $this->pot;
        } else {
            $this->playerChips += $this->pot / 2;
            $this->dealerChips += $this->pot / 2;
        }
    }

    public function resetGame()
    {
        if ($this->playerChips == 0 || $this->dealerChips == 0 || $this->dealerChips < 0) {
            $this->gameOver = true;
            throw new \LogicException('One of the players has run out of chips. The game cannot be played.');
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
    }

     public function getPlayerCards()
     {
         return $this->playerCards;
     }
     public function getDealerCards()
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


    public function __construct($startingChips = 100)
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

        // Set current bet to 0
        $this->currentBet = 0;
    }

    public function getPlayerScore(): int
    {
        $score = 0;
        $aceCount = 0;
        foreach ($this->playerCards as $card) {
            $value = $card->getValue();
            if ($value === 'King' || $value === 'Queen' || $value === 'Knight') {
                $score += 10;
            } elseif ($value === 'Ace') {
                $score += 11;
                $aceCount++;
            } else {
                $score += $value;
            }
        }
        // Handle the case where the player has aces and the score is over 21
        while ($score > 21 && $aceCount > 0) {
            $score -= 10;
            $aceCount--;
        }
        return $score;
    }

    public function getDealerScore(): int
    {
        // Same as getPlayerScore, but only showing the first card of the dealer
        $score = 0;
        $aceCount = 0;
        $firstCard = true;
        foreach ($this->dealerCards as $card) {
            if ($firstCard) {
                $firstCard = false;
                continue;
            }
            $value = $card->getValue();
            if ($value === 'King' || $value === 'Queen' || $value === 'Knight') {
                $score += 10;
            } elseif ($value === 'Ace') {
                $score += 11;
                $aceCount++;
            } else {
                $score += $value;
            }
        }
        // Handle the case where the dealer has aces and the score is over 21
        while ($score > 21 && $aceCount > 0) {
            $score -= 10;
            $aceCount--;
        }
        return $score;
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
    if ($amount <= 0) {
        throw new \InvalidArgumentException('Bet amount must be greater than zero.');
    }
    if ($amount > $this->playerChips) {
        throw new \InvalidArgumentException('You do not have enough chips to place that bet.');
    }
    if ($this->gameOver) {
        throw new \LogicException('The game is over. You cannot place a bet.');
    }

    $this->currentBet = $amount;
    $this->playerChips -= $amount;
    $this->dealerChips -= $amount;
    $this->pot = $amount * 2;
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
    } elseif ($this->getDealerScore() > $this->getPlayerScore()) {
        $this->dealerWins();
    } else {
        $this->tie();
    }
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


public function dealerPlay(): void
{
    while ($this->getDealerScore() < 17) {
        $this->dealerCards[] = $this->deck->dealCard();
    }
    if ($this->getDealerScore() > 21 || $this->getDealerScore() < $this->getPlayerScore()) {
        $this->playerChips += $this->currentBet * 2;
    } elseif ($this->getDealerScore() > $this->getPlayerScore()) {
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
    if ($this->getPlayerScore() == 21 && $this->getDealerScore() == 21 ) {
        return "It's a tie!";
    } elseif ($this->getPlayerScore() == 21) {
        return 'player';
    } elseif ($this->getPlayerScore() > 21) {
        return 'dealer';
    } elseif ($this->getDealerScore() > 21) {
        return 'player';
    } elseif ($this->getPlayerScore() > $this->getDealerScore()) {
        return 'player';
    } elseif ($this->getDealerScore() > $this->getPlayerScore()) {
        return 'dealer';
    } else {
        return "It's a tie!";
    }
}
}

