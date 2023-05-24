<?php

namespace App\Controller;

use Controller\Card\Card;
use Controller\Card\Deck;
use App\Controller\BlackjackGame;
use App\Controller\ScoreCalculator;
use App\Controller\PlayerWinHandler;
use App\Controller\DealerWinHandler;
use App\Controller\TieHandler;

/**
*
*A class for calculating the score of a given array of cards
*
*Calculates the score of a given array of cards based on the blackjack game rules
*@param array $cards An array of cards to calculate the score for
*@return int The total score of the given array of cards
*/


class ScoreCalculator
{
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
}


/**
 * Class PlayerWinHandler
 * Handles the case when the player wins.
 */
class PlayerWinHandler
{
    /**
     * Handles the case when the player wins.
     *
     * @param BlackjackGame $game The Blackjack game instance.
     * @return void
     */
    public function handle(BlackjackGame $game): void
    {
        $playerChips = $game->getPlayerChips();
        $playerChips += $game->getCurrentBet() * 2;

        $game->setGameOver(true);
    }
}

/**
 * Class DealerWinHandler
 * Handles the case when the dealer wins.
 */
class DealerWinHandler
{
    /**
     * Handles the case when the dealer wins.
     *
     * @param BlackjackGame $game The Blackjack game instance.
     * @return void
     */
    public function handle(BlackjackGame $game): void
    {
        $dealerChips = $game->getDealerChips();
        $dealerChips += $game->getCurrentBet() * 2;
        $game->setGameOver(true);
    }
}


/**
 * Class TieHandler
 * Handles the case when there is a tie.
 */
class TieHandler
{
    /**
     * Handles the case when there is a tie.
     *
     * @param BlackjackGame $game The Blackjack game instance.
     * @return void
     */
    public function handle(BlackjackGame $game): void
    {
        $game->setGameOver(true);
    }
}

/**

*Class BlackjackGame represents a game of Blackjack. The class manages the game state, player and dealer hands, chips, bets, and scoring.
*
*@property Deck $deck The deck of cards used for the game.
*
*@property array $playerCards The current cards in the player's hand.
*
*@property array $dealerCards The current cards in the dealer's hand.
*
*@property bool $playerTurn A flag indicating whether it is currently the player's turn.
*
*@property bool $gameOver A flag indicating whether the game is over.
*
*@property int $playerChips The number of chips the player currently has.
*
*@property int $dealerChips The number of chips the dealer currently has.
*
*@property int $currentBet The amount of chips currently bet by both the player and the dealer.
*
*@property int $maxRounds The maximum number of rounds to play before resetting the game.
*
*@property int $roundsPlayed The number of rounds that have been played so far.
*
*@property int $pot The amount of chips that have been bet by both the player and the dealer.
*
*@property string $winner The winner of the game.
*
*@property ScoreCalculator $scoreCalculator A calculator for determining the score of a hand of cards.
*/



class BlackjackGame
{
    private Deck $deck;
    private array $playerCards = [];
    private array $players = []; // Array to store player information
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
    private ScoreCalculator $scoreCalculator;
    private PlayerWinHandler $playerWinsHandler;
    private DealerWinHandler $dealerWinsHandler;
    private TieHandler $tieHandler;
    /**
     * Reset the game state, including player and dealer hands, the current turn, current bet, pot, winner, and game over flag.
     * The method also updates the player and dealer chip count based on the winner of the last round, and resets the game if the maximum number of rounds have been played.
     * @param string $winner The winner of the last round, either 'player', 'dealer', or '' if there was a tie.
     * @return void
    */
    public function resetGame(string $winner): void
    {

        $this->playerChips += ($winner === 'player') ? $this->pot : (($winner === 'dealer') ? 0 : $this->pot / 2);
        $this->dealerChips += ($winner === 'dealer') ? $this->pot : (($winner === 'player') ? 0 : $this->pot / 2);

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

    public function setGameOver(bool $gameOver): void
    {
        $this->gameOver = $gameOver;
    }

    /**
     * Returns an array of player's cards.
     * @return array The player's cards.
    */
    public function getPlayerCards(): array
    {
        return $this->playerCards;
    }

    /**
     * Returns an array of dealer's cards.
     * @return array The dealer's cards.
    */
    public function getDealerCards(): array
    {
        return $this->dealerCards;
    }

    /**
     * Returns the number of chips the player has.
     * @return int The number of chips the player has.
    */
    public function getPlayerChips(): int
    {
        return $this->playerChips;
    }

    /**
     * Returns the number of chips the dealer has.
     * @return int The number of chips the dealer has.
    */
    public function getDealerChips(): int
    {
        return $this->dealerChips;
    }

    /**
     * Returns the current bet amount.
     * @return int The current bet amount.
    */
    public function getCurrentBet(): int
    {
        return $this->currentBet;
    }

    /**
     * Constructor for the class.
     * @param int $startingChips The starting number of chips for both player and dealer. Default is 100.
    */
    public function __construct(int $playerCount = 1, int $startingChips = 100)
    {
        $this->deck = new Deck();
        $this->playerCards = array();
        $this->dealerCards = array();
        $this->playerTurn = true;
        $this->gameOver = false;
        $this->playerChips = $startingChips;
        $this->dealerChips = $startingChips;
        $this->currentBet = 0;
        $this->scoreCalculator = new ScoreCalculator();
        $this->playerWinsHandler = new PlayerWinHandler();
        $this->dealerWinsHandler = new DealerWinHandler();
        $this->tieHandler = new TieHandler();
    }

    /**
     * Starts the game by shuffling the deck and dealing cards to the player and dealer.
     *
     * @return void
     */
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

    // public function startGame(): void
    // {
    //     // Shuffle the deck
    //     $this->deck->shuffle();

    //     // Deal two cards to each player
    //     for ($i = 0; $i < $this->numPlayers; $i++) {
    //         $this->playerCards[$i][] = $this->deck->dealCard();
    //         $this->playerCards[$i][] = $this->deck->dealCard();
    //     }

    //     // Deal two cards to the dealer
    //     $this->dealerCards[] = $this->deck->dealCard();
    //     $this->dealerCards[] = $this->deck->dealCard();

    //     // Check if any player has a blackjack and declare the winner if they do
    //     for ($i = 0; $i < $this->numPlayers; $i++) {
    //         if ($this->getPlayerScore($i) === 21) {
    //             $this->gameOver = true;
    //             $this->winner = 'player';
    //             return;
    //         }
    //     }

    //     // Set current bet to 0
    //     $this->currentBet = 0;
    // }

    /**
     * Calculates and returns the score of the player's hand.
     *
     * @return int The player's score.
     */
    public function getPlayerScore(): int
    {
        return $this->scoreCalculator->calculateScore($this->playerCards);
    }

    /**
     * Calculates and returns the score of the dealer's hand, showing only the first card.
     *
     * @return int The dealer's score.
     */
    public function getDealerScore(): int
    {
        // Only show the first card of the dealer
        $dealerCards = array_slice($this->dealerCards, 1);
        return $this->scoreCalculator->calculateScore($dealerCards);
    }

    /**
     * Determines if it is currently the player's turn.
     *
     * @return bool True if it is the player's turn, false otherwise.
     */
    public function isPlayerTurn(): bool
    {
        return $this->playerTurn;
    }

    /**
     * Determines if the game is over.
     *
     * @return bool True if the game is over, false otherwise.
     */
    public function isGameOver(): bool
    {
        return $this->gameOver;
    }

    /**
     * Places a bet for the current round and updates the pot and player/dealer chip counts.
     *
     * @param int $amount The amount of the bet.
     * @return void
     */
    public function placeBet(int $amount)
    {

        $this->currentBet = $amount;
        $this->playerChips -= $amount;
        $this->dealerChips -= $amount;
        $this->pot = $amount * 2;
    }

    /**
     * Handles the logic when the player chooses to hit.
     *
     * @return void
     */
    public function playerHit(): void
    {
        if (!$this->playerTurn || $this->gameOver) {
            return;
        }

        $this->playerCards[] = $this->deck->dealCard();
        if ($this->getPlayerScore() > 21) {
            $this->dealerWinsHandler->handle($this);
        }

        // Check if the player has a blackjack and declare the winner if they do
        if ($this->getPlayerScore() === 21) {
            $this->gameOver = true;
            $this->winner = 'player';
            return;
        }
    }

    /**
     * Handles the logic when the player chooses to stand.
     *
     * @return void
     */
    public function playerStand(): void
    {
        if (!$this->playerTurn || $this->gameOver) {
            return;
        }

        $this->playerTurn = false;

        while ($this->getDealerScore() < 17) {
            $this->dealerCards[] = $this->deck->dealCard();
        }

        $dealerScore = $this->getDealerScore();
        $playerScore = $this->getPlayerScore();

        if ($dealerScore > 21 || $playerScore > $dealerScore) {
            $this->playerWinsHandler->handle($this);
            return;
        }

        if ($dealerScore > $playerScore) {
            $this->dealerWinsHandler->handle($this);
            return;
        }

        $this->tieHandler->handle($this);
    }




    /**
         * Plays the dealer's turn.
         *
         * @return void
         */
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

        $this->getDealerScore() > $this->getPlayerScore()
        ? $this->dealerChips += $this->currentBet * 2
        : $this->playerChips += $this->currentBet;

        $this->gameOver = true;
    }

    /**
     * Determines the winner of the game.
     *
     * @return string|null Returns "player" if the player wins, "dealer" if the dealer wins, or "It's a tie!" if there is a tie. Returns null if the game is not over.
     */
    public function getWinner(): ?string
    {
        // if (!$this->gameOver) {
        //     return null;
        // }

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
        return $this->winner ?? "It's a tie!";
    }
}
