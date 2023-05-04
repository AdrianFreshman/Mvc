<?php

namespace Controller\Card;

require_once __DIR__ . '/../../src/Controller/blackJack.php';
require_once __DIR__ . '/../../src/Controller/card.php';


use PHPUnit\Framework\TestCase;


class ScoreCalculatorTest extends TestCase
{
    public function testCalculateScore()
    {
        $calculator = new ScoreCalculator();
        
        // Test for empty array
        $this->assertEquals(0, $calculator->calculateScore([]));
        
        // Test for non-empty array
        $deck = new Deck(); // Initialize the deck
        $cards = [
            $deck->dealCard(),
            $deck->dealCard()
        ];
        $this->assertEquals(21, $calculator->calculateScore($cards));
    }
}


class BlackjackGameTest extends TestCase
{

        public function testStartGamePlayerCardsAreUnique()
{
    $game = new BlackjackGame();
    $game->startGame();
    $playerCards = $game->getPlayerCards();
    $this->assertCount(2, array_unique($playerCards, SORT_REGULAR));
}

public function testStartGameDealerCardsAreUnique()
{
    $game = new BlackjackGame();
    $game->startGame();
    $dealerCards = $game->getDealerCards();
    $this->assertCount(2, array_unique($dealerCards, SORT_REGULAR));
}

    public function testGetPlayerScore()
    {
        $game = new BlackjackGame();
        $game->startGame();
        $scoreCalculator = new ScoreCalculator();
        $playerCards = $game->getPlayerCards();
        $this->assertEquals($scoreCalculator->calculateScore($playerCards), $game->getPlayerScore());
    }

    public function testGetDealerScore()
    {
        $game = new BlackjackGame();
        $game->startGame();
        $scoreCalculator = new ScoreCalculator();
        $dealerCards = $game->getDealerCards();
        $this->assertEquals($scoreCalculator->calculateScore(array_slice($dealerCards, 1)), $game->getDealerScore());
    }

    public function testIsPlayerTurn()
    {
        $game = new BlackjackGame();
        $this->assertTrue($game->isPlayerTurn());
    }

    public function testIsGameOver()
    {
        $game = new BlackjackGame();
        $this->assertFalse($game->isGameOver());
        $game->resetGame('');
        $this->assertFalse($game->isGameOver());
        $game->resetGame('player');
        $this->assertFalse($game->isGameOver());
        $game->resetGame('dealer');
        $this->assertFalse($game->isGameOver());
        $game->resetGame('tie');
        $this->assertFalse($game->isGameOver());
        $game->resetGame('player');
        $game->playerChips = 0;
        $this->assertTrue($game->isGameOver());
        $game->resetGame('dealer');
        $game->dealerChips = 0;
        $this->assertTrue($game->isGameOver());
    }
}