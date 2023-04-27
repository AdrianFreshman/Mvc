<?php

namespace App\Controller;

use Controller\Card\Card;
use Controller\Card\Deck;
use Controller\Card\BlackjackGame;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route("/api", name: "api_landing")]
    public function apiLanding(): Response
    {
        $routes = [
            'deck' => [
                'url' => '/api/deck',
                'description' => 'Returns the entire deck sorted by color and value.'
            ],
            'shuffle' => [
                'url' => '/api/deck/shuffle',
                'description' => 'Shuffles the deck and returns the new deck order.'
            ],
            'draw' => [
                'url' => '/api/deck/draw',
                'description' => 'Draws one card from the deck and returns it, along with the number of cards remaining.'
            ],
            'draw_multiple' => [
                'url' => '/api/deck/draw/{number}',
                'description' => 'Draws {number} cards from the deck and returns them, along with the number of cards remaining.'
            ],
            'deal' => [
                'url' => '/api/deck/deal/{players}/{cards}',
                'description' => 'Deals {cards} cards to each of {players} players and returns their hands, along with the number of cards remaining in the deck.'
            ],
            'quote' => [
                'url' => '/api/quote',
                'description' => 'Returns a random quote along with its date and timestamp.'
            ],
            'game_state' => [
                'url' => '/api/game',
                'description' => 'Returns game state of blackjack'
            ]
        ];

        return $this->render('api.landing.html.twig', [
    'routes' => $routes,
]);
    }


    #[Route("/api/deck", name: "deck")]
    public function getDeck(): JsonResponse
    {
        $deck = new Deck();

        $cards = $deck->getAllCards();

        return $this->json($cards);
    }



#[Route('/api/game', name: 'game_state')]
public function getGameState(SessionInterface $session): JsonResponse
{
    $game = $session->get('blackjack_game');

    if (!$game) {
        $game = new BlackjackGame();
        $session->set('blackjack_game', $game);
    }

    // Get the current game state
     $state = [
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

    return $this->json($state);
}

    #[Route("/api/deck/shuffle", name: "shuffle")]
    public function shuffle(SessionInterface $session): JsonResponse
    {
        $deck = $session->get('deck') ?? new Deck();

        if ($deck instanceof Deck) {
            $deck->shuffle();
            $session->set('deck', $deck);
            $cards = $deck->getAllCards();
            return $this->json($cards);
        }
        return new JsonResponse(['error' => 'Invalid deck object.'], 400);

    }

    #[Route("/api/deck/draw", name: "draw")]
    #[Route("/api/deck/draw/{number}", name: "draw_multiple")]
    public function drawCards(SessionInterface $session, Request $request): JsonResponse
    {
        $deck = $session->get('deck') ?? new Deck();

        $number = $request->get('number', 1);

        $cards = [];

        for ($i = 0; $i < $number; $i++) {
            $card = $deck->dealCard();

            if ($card) {
                $cards[] = $card;
            }
            break;
        }

        $session->set('deck', $deck);

        $response = [
            'cards' => $cards,
            'count' => $deck->countCards() ?? 0
        ];

        return $this->json($response);
    }


#[Route("/api/deck/deal/{players}/{cards}", name: "deal")]
public function dealCards(SessionInterface $session, int $players, int $cards): JsonResponse
{
    $deck = $session->get('deck') ?? new Deck();

    $hands = [];

    for ($i = 0; $i < $players; $i++) {
        $hand = [];

        for ($j = 0; $j < $cards; $j++) {
            $hand[] = $deck->dealCard();
        }

        $hands[] = $hand;
    }

    $session->set('deck', $deck);

    $response = [
        'hands' => $hands,
        'remainingCards' => $deck->countCards() ?? 0
    ];

    return $this->json($response);
}

    #[Route("/api/quote", name: "quote")]
    public function jsonQuote(): Response
    {
        $quotes = [
            "The best way to predict the future is to invent it.",
            "The only way to do great work is to love what you do.",
            "Stay hungry, stay foolish.",
            "The future belongs to those who believe in the beauty of their dreams.",
            "If you want to live a happy life, tie it to a goal, not to people or things.",
            "The only limit to our realization of tomorrow will be our doubts of today.",
            "The only thing we have to fear is fear itself.",
            "You can't use up creativity. The more you use, the more you have.",
            "Believe you can and you're halfway there.",
            "I have not failed. I've just found 10,000 ways that won't work.",
            "The power of imagination makes us infinite."
        ];

        $selectedQuote = $quotes[array_rand($quotes)];

        $data = [
            'quote' => $selectedQuote,
            'date' => date('Y-m-d'),
            'timestamp' => time(),
        ];

        $response = new Response();
        $response->setContent(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
