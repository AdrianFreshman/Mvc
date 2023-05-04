<?php

namespace Controller\Card;

require_once __DIR__ . '/../../src/Controller/card.php';
require_once __DIR__ . '/../../src/Controller/blackJack.php';

use PHPUnit\Framework\TestCase;

class BaseCardTest extends TestCase
{
    public function testCreateBaseCard()
    {
        $value = 5;
        $suit = 'Hearts';

        $card = new BaseCard($value, $suit);

        $this->assertInstanceOf(Card::class, $card);
        $this->assertEquals($value, $card->getValue());
        $this->assertEquals($suit, $card->getSuit());
        $this->assertNotEmpty($card->getImagePath());
    }
}


class DeckTest extends TestCase
{

    
    
    public function testShuffleMethodShufflesCards(): void
    {
        $deck = new Deck();
        $cardsBeforeShuffle = $deck->getAllCards();
        $deck->shuffle();
        $cardsAfterShuffle = $deck->getAllCards();
        $this->assertNotEquals($cardsBeforeShuffle, $cardsAfterShuffle);
    }
    
public function testDealCardMethodReturnsNullWhenDeckIsEmpty(): void
    {
        $deck = new Deck();
        $this->assertCount(52, $deck->getAllCards());
        
        // Empty the deck
        for ($i = 0; $i < 52; $i++) {
            $deck->dealCard();
        }
        
        $this->assertNull($deck->dealCard());
    }

    public function testDealCardMethodReducesNumberOfCardsInDeck(): void
    {
        $deck = new Deck();
        $this->assertEquals(52, $deck->countCards());

        $card = $deck->dealCard();
        $this->assertInstanceOf(Card::class, $card);
        $this->assertEquals(51, $deck->countCards());

        $card = $deck->dealCard();
        $this->assertInstanceOf(Card::class, $card);
        $this->assertEquals(50, $deck->countCards());

        // Continue for remaining cards...
    }
    
    
    public function testGetAllCardsMethodReturnsAllCards(): void
    {
        $deck = new Deck();
        $cards = $deck->getAllCards();
        $this->assertCount(52, $cards);
        foreach ($cards as $card) {
            $this->assertInstanceOf(Card::class, $card);
        }
    }
    
    public function testCountCardsMethodReturnsCorrectNumberOfCards(): void
    {
        $deck = new Deck();
        $this->assertEquals(52, $deck->countCards());
        $deck->dealCard();
        $this->assertEquals(51, $deck->countCards());
    }
}
