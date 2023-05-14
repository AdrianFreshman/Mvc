<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Controller\Card\Card;
use Controller\Card\Deck;
use Controller\Card\TexasHoldem;
use Controller\Card\BlackjackGame;
use Symfony\Component\HttpFoundation\Request;

class LuckyControllerTwig extends AbstractController
{
    #[Route("/card", name: "card")]
    public function card(): Response
    {
        $links = [
            'deck' => [
                'url' => 'card_deck',
                'description' => 'Returns the entire deck sorted by color and value.'
            ],
            'shuffle' => [
                'url' => 'card_deck_shuffle',
                'description' => 'Shuffles the deck and returns the new deck order.'
            ],
            'draw' => [
                'url' => 'card_deck_draw',
                'description' => 'Draws one card from the deck and returns it, along with the number of cards remaining.'
            ],
            'draw_multiple' => [
                'url' => 'card_deck_draw_multiple',
                'description' => 'Draws {number} cards from the deck and returns them, along with the number of cards remaining.'
            ],
            'deal' => [
                'url' => 'card_deck_deal',
                'description' => 'Deals {cards} cards to each of {players} players and returns their hands, along with the number of cards remaining in the deck.'
            ],
            'quote' => [
                'url' => 'quote',
                'description' => 'Returns a random quote along with its date and timestamp.'
            ]
        ];

        return $this->render('card.html.twig', [
        'links' => $links,
    ]);
    }


    #[Route("/game", name: "game")]
        public function game(): Response
        {
            $links = [
                'blackjack' => [
                    'url' => 'blackjack',
                    'description' => 'Click to play blackjack'
                ],
            'Documentation' => [
                'url' => 'docs',
                'description' => 'Documentations for page.'
            ]
            ];

            return $this->render('blackjack.landing.html.twig', [
            'links' => $links,
    ]);
        }

    #[Route("/game/doc", name: "docs")]
    public function doc(): Response
    {
        return $this->render('blackjack.doc.html.twig');

    }

    #[Route("/card/deck", name: "card_deck")]
    public function deck(SessionInterface $session): Response
    {
        $deck = $session->get('deck');

        if (!$deck) {
            $deck = new Deck();
            $session->set('deck', $deck);
        }

        return $this->render('card.deck.html.twig', [
            'cards' => $deck->getAllCards(),
            'count' => $deck->countCards()
        ]);
    }

    #[Route("/card/deck/shuffle", name: "card_deck_shuffle")]
    public function shuffle(SessionInterface $session): Response
    {
        $deck = new Deck();
        $deck->shuffle();
        $session->set('deck', $deck);

        return $this->render('card.deck.shuffle.html.twig', [
               'cards' => $deck->getAllCards(),
               'count' => $deck->countCards()
           ]);
    }

#[Route("/card/deck/draw/{number}", name: "card_deck_draw_multiple")]
#[Route("/card/deck/draw", name: "card_deck_draw")]
public function draw(SessionInterface $session, int $number = 1): Response
{
    $deck = $session->get('deck');

    if (!$deck instanceof Deck) {
        $deck = new Deck();
        $session->set('deck', $deck);
    }

    $cards = [];
    for ($i = 0; $i < $number; $i++) {
        $card = $deck->dealCard();
        if (!$card instanceof Card) {
            break;
        }
        $cards[] = $card;
    }

    return $this->render('card.deck.draw.html.twig', [
        'cards' => $cards,
        'count' => $deck->countCards()
    ]);
}

#[Route("/card/deck/deal/{players}/{cards}", name: "card_deck_deal")]
public function deal(SessionInterface $session, int $players, int $cards): Response
{
    $deck = $session->get('deck');

    if (!$deck instanceof Deck) {
        $deck = new Deck();
        $session->set('deck', $deck);
    }

    $hands = [];

    for ($i = 0; $i < $players; $i++) {
        $hand = [];

        for ($j = 0; $j < $cards; $j++) {
            $card = $deck->dealCard();
            if (!$card instanceof Card) {
                break;
            }
            $hand[] = $card;
        }

        $hands[] = $hand;
    }

    $remainingCards = $deck->countCards();
    $session->set('remaining_cards', $remainingCards);

    return $this->render('card.deck.deal.html.twig', [
        'hands' => $hands,
        'remainingCards' => $remainingCards
    ]);

}

#[Route("/texas-holdem", name: "texas_holdem")]
public function texasHoldem(): Response
{
    // Create a new instance of the texasHoldem class
    $game = new texasHoldem();

    // Call the Play method to start the game
    $game->Play();

    // Get the current player index and name
    $currentPlayer = $game->getCurrentPlayerIndex();
    // $currentPlayerName = $game->getPlayers()[$currentPlayer]->getName();

    // Create an array with the game instance data

    $content = $this->render('poker.html.twig', [
            'current_player' => $currentPlayer,
            'game' => $game,
        ]);

    return new Response($content);
}

#[Route('/blackjack', name: 'blackjack')]
public function playBlackjack(SessionInterface $session, Request $request): Response
{
    $game = $session->get('blackjack_game');
    $action = $request->request->get('action');
    $betAmount = $request->request->get('bet-amount');

    if (!$game) {
        $game = new BlackjackGame();
        $session->set('blackjack_game', $game);
        
    }

    switch ($action) {
        case 'hit':
            $game->playerHit();
            break;
        case 'stand':
            $game->playerStand();
            break;
        case 'bet':
            $game->placeBet($betAmount);
            $game->startGame();
            break;
        case 'reset':
            $session->invalidate();
            $game = new BlackjackGame();
            $session->set('blackjack_game', $game);
            break;
        case 'next':
            $winner = $game->getWinner();
            $game->resetGame($winner);
            break;
        default:
            break;
    }

    $data = [
        'playerScore' => $game->getPlayerScore(),
        'dealerScore' => $game->getDealerScore(),
        'playerCards' => $game->getPlayerCards(),
        'dealerCards' => $game->getDealerCards(),
        'playerTurn' => $game->isPlayerTurn(),
        'gameOver' => $game->isGameOver(),
        'winner' => $game->getWinner(),
        'playerChips' => $game->getPlayerChips(),
        'dealerChips' => $game->getDealerChips(),
    ];

    return $this->render('blackjack.html.twig', $data);
}

#[Route("/metrics", name: "metrics")]
public function metrics(): Response
{
    return $this->render('metrics.html.twig');
}
}
