<?php

namespace Controller\Card;

class BlackjackGame
{
    private Deck $deck;
    private array $playerCards;
    private array $dealerCards;
    private bool $playerTurn;
    private bool $gameOver;

    public function __construct()
    {
        $this->deck = new Deck();
        $this->playerCards = array();
        $this->dealerCards = array();
        $this->playerTurn = true;
        $this->gameOver = false;
    }

    public function startGame(): void
    {
        // Shuffle the deck and deal two cards to the player and two cards to the dealer
        $this->deck->shuffle();
        $this->playerCards[] = $this->deck->dealCard();
        $this->dealerCards[] = $this->deck->dealCard();
        $this->playerCards[] = $this->deck->dealCard();
        $this->dealerCards[] = $this->deck->dealCard();
    }

    public function getPlayerScore(): int
    {
        $score = 0;
        $aceCount = 0;
        foreach ($this->playerCards as $card) {
            $value = $card->getValue();
            if ($value === 'King' || $value === 'Queen' || $value === 'Knight') {
                $score += 10;
            } else if ($value === 'Ace') {
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
            } else if ($value === 'Ace') {
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

   public function playerHit(): void
{
    if ($this->playerTurn) {
        $this->playerCards[] = $this->deck->dealCard();
        if ($this->getPlayerScore() > 21) {
            $this->gameOver = true;
        }
    }
}

public function playerStand(): void
{
    if ($this->playerTurn) {
        $this->playerTurn = false;
        // Dealer takes their turn until their score is at least 17
        while ($this->getDealerScore() < 17) {
            $this->dealerCards[] = $this->deck->dealCard();
        }
        // Check who won the game
        $this->gameOver = true;
    }
}

public function getWinner(): string
{
    $playerScore = $this->getPlayerScore();
    $dealerScore = $this->getDealerScore();
    if ($playerScore > 21) {
        return "Dealer";
    } else if ($dealerScore > 21) {
        return "Player";
    } else if ($playerScore == $dealerScore) {
        return "Tie";
    } else if ($playerScore > $dealerScore) {
        return "Player";
    } else {
        return "Dealer";
    }
}
}

