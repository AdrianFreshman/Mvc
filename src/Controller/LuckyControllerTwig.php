<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Controller\Card\Card;
use Controller\Card\Deck;
use Controller\Card\TexasHoldem;

class LuckyControllerTwig extends AbstractController
{
    #[Route("/lucky", name: "lucky_number")]
    public function number(): Response
    {
        $number = random_int(0, 100);

        $data = [
            'number' => $number,
            'images' => ['one.png', 'six.png', 'five.png', 'four.png', 'three.png', 'two.png', 'sadpug.gif']
        ];

        return $this->render('lucky_number2.html.twig', $data);
    }

    #[Route("/", name: "home")]
    public function home(): Response
    {
        return $this->render('home.html.twig');
    }

    #[Route("/about", name: "about")]
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }

    #[Route("/report", name: "report")]
    public function report(): Response
    {
        return $this->render('report.html.twig');
    }

    #[Route("/report#kmom01", name: "kmom01")]
    public function kmom01(): Response
    {
        return $this->render('report.html.twig');
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
    $response->headers->set('Content-Type', 'application/json');
    $response->setContent(json_encode($data));

    return $response;
}


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

    #[Route("/card/deck", name: "card_deck")]
    public function deck(SessionInterface $session): Response
    {
        $deck = $session->get('deck');

        $deck = new Deck();
        $session->set('deck', $deck);

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
    $current_player = $game->getCurrentPlayerIndex();
    $current_player_name = $game->getPlayers()[$current_player]->getName();

    // Create an array with the game instance data

    $content = $this->render('poker.html.twig', [
            'current_player' => $current_player,
            'game' => $game,
        ]);

        return new Response($content);
}
}
