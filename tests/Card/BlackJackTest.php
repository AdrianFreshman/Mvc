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

    public function testIsGameOver(): void
    {
        $game = new BlackjackGame();
        $deck = new Deck();
        $playerCards = [
            $deck->dealCard(),
            $deck->dealCard()
        ];
        $dealerCards = [
            $deck->dealCard(),
            $deck->dealCard()
        ];
        $game->startGame();

        $this->assertFalse($game->isGameOver());
    }

    public function testPlaceBet(): void
    {
        $game = new BlackjackGame();
        $game->placeBet(50);
        $this->assertSame(50, $game->getCurrentBet());
    }

    public function testPlace(): void
    {
        $game = new BlackjackGame();
        $game->placeBet(10);
        $this->assertSame(10, $game->getCurrentBet());
        $this->assertSame(90, $game->getPlayerChips());
    }

     public function testGetPlayerChips(): void
    {
        $game = new BlackjackGame();
        $this->assertEquals(100, $game->getPlayerChips());
    }

    public function testGetDealerChips(): void
    {
        $game = new BlackjackGame();
        $this->assertEquals(100, $game->getDealerChips());
    }

    public function testGetCurrentBet(): void
    {
        $game = new BlackjackGame();
        $this->assertEquals(0, $game->getCurrentBet());
    }

    public function testResetGame(): void
    {
        $game = new BlackjackGame();
        $game->resetGame('player');
        $this->assertEquals(100, $game->getDealerChips());
        $this->assertEquals(0, $game->getCurrentBet());
        // Add more assertions as needed
    }

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

    public function testPlayerHit(): void
    {
    $game = new BlackjackGame();
    $game->startGame();
    $playerScore = $game->getPlayerScore();
    $game->playerHit();
    $newPlayerScore = $game->getPlayerScore();

    // Assert that the player has one additional card
    self::assertCount(3, $game->getPlayerCards());

    // Assert that the player's score has increased
    self::assertGreaterThan($playerScore, $newPlayerScore);

    // Add cards to the player's hand until their score is over 21
    while ($game->getPlayerScore() <= 21) {
        $game->playerHit();
    }

    // Assert that the game is over
    self::assertTrue($game->isGameOver());

    // Assert that the winner is the dealer
    self::assertSame('dealer', $game->getWinner());
}

public function testPlayerStand(): void
{
    $game = new BlackjackGame();
    $game->startGame();
    $playerScore = $game->getPlayerScore();
    $game->playerStand();
    $newPlayerScore = $game->getPlayerScore();

    // Assert that the player's score has not changed
    self::assertSame($playerScore, $newPlayerScore);


    // Add cards to the dealer's hand until their score is over 16
    while ($game->getDealerScore() < 17) {
        $game->dealerHit();
    }

    // Assert that the game is over
    self::assertTrue($game->isGameOver());

    // Assert that the winner is either the player or the dealer
    self::assertContains($game->getWinner(), ['player', 'dealer']);
}

}