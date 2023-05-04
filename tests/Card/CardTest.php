<?php

namespace Controller\Card;

require_once __DIR__ . '/../../src/Controller/card.php';

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