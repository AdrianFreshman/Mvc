<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

    #[Route("/api/quote",name:"quote")]
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

        return $this->render('quotes.html.twig', [
    'quoteData' => $data,
]);
    }
}


