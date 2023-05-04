<?php

namespace App\Dice;

require_once __DIR__ . '/../../src/Controller/Dice/dice.php';
require_once __DIR__ . '/../../src/Controller/card.php';


use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DiceTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateDice()
{
    $die = new Dice();
    $this->assertInstanceOf(Dice::class, $die);

    $res = $die->getAsString();
    $this->assertNotEmpty($res);
}
}