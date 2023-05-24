<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Entity\EffektAvCovid19;
use App\Repository\EffektAvCovid19Repository;
use App\Entity\Boende;
use App\Repository\BoendeRepository;
use App\Entity\Unemployement;
use App\Repository\UnemploymentRepository;
use App\Controller\EffektAvCovid19Helper;
use App\Controller\HelperBoende;
use App\Controller\UnemployementHelper;
use Symfony\Component\HttpFoundation\JsonResponse;

class projectController extends AbstractController

{
    private $entityManager;
    private $effektAvCovid19Helper;
    private $helperBoende;
    private $unemploymentHelper;
    // private $effektAvCovid19Repository;

    public function __construct(EntityManagerInterface $entityManager, EffektAvCovid19Helper $effektAvCovid19Helper,HelperBoende $helperBoende,UnemployementHelper $unemploymentHelper,)
    {
        $this->entityManager = $entityManager;
        $this->effektAvCovid19Helper = $effektAvCovid19Helper;
        $this->helperBoende = $helperBoende;
        $this->unemploymentHelper = $unemploymentHelper;
        // $this->effektAvCovid19Repository = $effektAvCovid19Repository;
    }

    #[Route("/proj", name: "proj")]
    public function project(): Response
    {
        $links = [
                'vizuailizer' => [
                    'url' => 'statisticsDeaths',
                    'description' => 'Click to Covid Statstic'
                ],
                'BoendeVizualizer' => [
                    'url' => 'statisticsBoende',
                    'description' => 'Click to Covid 70+ special living'
                ],
                'NoBoendeVizualizer' => [
                    'url' => 'statisticsNoBoende',
                    'description' => 'Click to Covid 70+ no special living'
                ],

                'UnemployementVizualizer' => [
                    'url' => 'statisticsUnenployement',
                    'description' => 'Click to Covid unemployement data'
                ],

            ];

            return $this->render('vizualizer.landing.html.twig', [
            'links' => $links,
    ]);
    }


    #[Route("/proj/api", name: "proj_api")]
    public function projectApi(): Response
    {
        $links = [
            'api_effekt_av_covid19' => [
                'url' => 'api_effekt_av_covid19',
                'description' => 'Returns all EffektAvCovid19 data in JSON format.'
            ],
            'api_boende' => [
                'url' => 'api_boende',
                'description' => 'Returns all Boende data in JSON format.'
            ],
            'api_unemployment' => [
                'url' => 'api_unemployment',
                'description' => 'Returns all Unemployment data in JSON format.'
            ],

            'api_total_deaths' => [
                'url' => 'api_total_deaths',
                'description' => 'Returns by total_deaths.'
            ],

            'api_female_deaths' => [
                'url' => 'api_female_deaths',
                'description' => 'Returns by female deaths.'
            ],

            'api_boende_deaths_v' => [
                'url' => 'api_boende_deaths_v',
                'description' => 'Returns by vecka.'
            ],

            'api_unemployement_age' => [
                'url' => 'api_unemployement_age',
                'description' => 'Returns by age range.'
            ],
        ];

        return $this->render('vizualizer.landing2.html.twig', [
            'links' => $links,
        ]);
    }

    #[Route("/proj/about", name: "proj_about")]
    public function about(): Response
    {
        return $this->render('about.project.html.twig');
    }


    #[Route('/proj/vizualizer', name: 'statisticsDeaths')]
    public function vizualizer(EffektAvCovid19Repository $effektAvCovid19Repository): Response
    {

        $this->entityManager->createQuery('DELETE FROM App\Entity\EffektAvCovid19')->execute();

        $entity = new EffektAvCovid19();
        $this->effektAvCovid19Helper->setEffektAvCovid19Data($entity);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        $data = $effektAvCovid19Repository->findAll();
        $formattedData = $this->effektAvCovid19Helper->formatEffektAvCovid19Data($data);

        return $this->render('show_all.statistics.html.twig', ['formattedData' => $formattedData]);
    }



#[Route('/proj/boende', name: 'statisticsBoende')]
public function boendevizualizer(BoendeRepository $boendeRepository): Response
{
    $this->entityManager->createQuery('DELETE FROM App\Entity\Boende')->execute();
         // Set the data
    $data = [
        [1, 765.9, 982.8, 883.0, 768.9, 729.4],
        [2, 820.4, 923.7, 849.8, 743.6, 797.2],
        [3, 758.3, 876.0, 814.1, 785.3, 823.3],
        [4, 840.7, 838.3, 780.9, 732.2, 651.1],
        [5, 779.8, 755.3, 684.0, 731.0, 747.7],
        [6, 670.8, 756.6, 791.1, 732.2, 639.4],
        [7, 702.5, 790.5, 817.9, 689.2, 762.0],
        [8, 727.9, 843.3, 892.0, 690.5, 664.2],
        [9, 664.5, 790.5, 885.6, 670.3, 674.6],
        [10, 708.8, 687.5, 884.3, 628.5, 682.4],
        [11, 607.4, 713.8, 843.5, 666.5, 652.4],
        [12, 670.8, 590.7, 721.0, 571.6, 685.0],
        [13, 606.1, 648.5, 746.5, 531.1, 798.5],
        [14, 583.3, 644.7, 694.2, 608.3, 991.7],
        [15, 626.4, 610.8, 613.8, 596.9, 1103.9],
        [16, 599.8, 622.1, 601.0, 603.2, 1149.5],
        [17, 530.0, 633.4, 537.2, 658.9, 956.4],
        [18, 559.2, 629.6, 548.7, 588.1, 935.6],
        [19, 552.9, 598.2, 495.1, 583.0, 842.9],
        [20, 509.8, 545.4, 487.5, 546.3, 762.0],
        [21, 531.3, 507.7, 463.2, 459.1, 704.6],
        [22, 470.4, 522.8, 474.7, 500.8, 0],
        [23, 455.2, 500.2, 490.0, 505.9, 0],
        [24, 448.9, 500.2, 454.3, 447.7, 0],
        [25, 437.5, 457.5, 446.6, 478.0, 0],
        [26, 475.5, 476.3, 511.7, 491.9, 0],
        [27, 499.6, 505.2, 483.6, 460.3, 0],
        [28, 488.2, 456.2, 541.0, 474.2, 0],
        [29, 512.3, 487.6, 589.5, 465.4, 0],
        [30, 556.7, 483.9, 552.5, 460.3, 0],
        [31, 531.3, 482.6, 562.7, 479.3, 0],
        [32, 530.0, 498.9, 455.5, 481.8, 0],
        [33, 490.7, 461.2, 490.0, 500.8, 0],
        [34, 518.6, 432.3, 468.3, 479.3, 0],
        [35, 460.3, 482.6, 458.1, 560.2, 0],
        [36, 480.6, 471.3, 454.3, 428.7, 0],
        [37, 434.9, 460.0, 426.2, 440.1, 0],
        [38, 437.5, 412.2, 491.3, 430.0, 0],
        [39, 437.5, 447.4, 427.5, 517.2, 0],
        [40, 424.8, 465.0, 490.0, 508.4, 0],
        [41, 471.7, 526.6, 511.7, 491.9, 0],
        [42, 533.8, 467.5, 427.5, 516.0, 0],
        [43, 492.0, 485.1, 468.3, 543.8, 0],
        [44, 538.9, 488.9, 497.7, 488.2, 0],
        [45, 535.1, 519.0, 484.9, 490.7, 0],
        [46, 537.6, 488.9, 432.6, 486.9, 0],
        [47, 500.9, 500.2, 407.1, 499.5, 0],
        [48, 531.3, 485.1, 502.8, 533.7, 0],
        [49, 545.3, 546.7, 520.6, 536.2, 0],
        [50, 592.2, 511.5, 496.4, 538.7, 0],
        [51, 563.0, 581.9, 497.7, 561.5, 0],
        [52, 680.9, 590.7, 524.5, 485.6, 0],
        [53, 0, 0, 0, 0, 0],
    ];

$helper = new HelperBoende(); // Create an instance of the HelperBoende class

    foreach ($data as $item) {
        $entity = new Boende();
        $helper->setData($item, $entity); // Use the setData method to set the data

        $this->entityManager->persist($entity);
    }

    $this->entityManager->flush();

    // Get the data
    $data = $boendeRepository->findAll();

    // Transform the data into separate items
    $formattedData = [];
    foreach ($data as $item) {
        $formattedData[] = $helper->getData($item); // Use the getData method to retrieve the data
    }

    return $this->render('show_all.statistics2.html.twig', ['formattedData' => $formattedData]);
}



#[Route('/proj/noboende', name: 'statisticsNoBoende')]
public function boendevizualizersecond(BoendeRepository $boendeRepository): Response
{
    $this->entityManager->createQuery('DELETE FROM App\Entity\Boende')->execute();
    
    // Set the data
    $data = [
    [1, 111.3, 118.5, 103.9, 131.7, 101.2],
    [2, 123.3, 114.8, 124.6, 103.4, 112.4],
    [3, 128.8, 138.1, 106.9, 90.3, 105.3],
    [4, 129.6, 104.9, 139.4, 101.0, 107.8],
    [5, 102.1, 138.3, 144.9, 101.5, 114.7],
    [6, 117.8, 122.9, 126.0, 131.6, 123.3],
    [7, 125.5, 123.8, 131.1, 97.7, 98.4],
    [8, 108.4, 145.0, 145.5, 111.0, 109.2],
    [9, 113.6, 143.9, 134.0, 130.1, 130.6],
    [10, 118.4, 139.5, 152.7, 76.0, 116.3],
    [11, 114.2, 123.9, 146.3, 116.8, 116.1],
    [12, 114.4, 91.5, 153.4, 121.0, 99.3],
    [13, 150.7, 116.1, 147.4, 112.1, 138.2],
    [14, 139.2, 140.0, 177.5, 106.0, 152.9],
    [15, 135.1, 151.0, 121.2, 88.5, 163.0],
    [16, 111.6, 123.2, 142.3, 126.9, 139.5],
    [17, 128.6, 117.4, 111.6, 114.4, 155.9],
    [18, 110.2, 122.4, 120.2, 128.9, 150.9],
    [19, 97.3, 151.7, 114.9, 125.2, 143.6],
    [20, 126.5, 106.4, 121.3, 115.7, 124.5],
    [21, 121.3, 119.7, 103.1, 119.6, 132.7],
    [22, 126.0, 122.0, 101.4, 122.7,0],
    [23, 129.6, 122.2, 127.9, 115.5,0],
    [24, 121.4, 118.2, 133.2, 111.5,0],
    [25, 140.7, 104.8, 115.9, 96.6,0],
    [26, 105.4, 134.2, 143.5, 124.8,0],
    [27, 123.0, 123.6, 115.9, 109.0,0],
    [28, 140.0, 112.0, 129.8, 131.2,0],
    [29, 134.3, 129.0, 154.6, 100.3,0],
    [30, 146.3, 114.4, 128.9, 121.0,0],
    [31, 154.8, 123.3, 126.6, 121.1,0],
    [32, 98.8, 142.6, 136.8, 119.8,0],
    [33, 119.3, 131.5, 144.3, 112.8,0],
    [34, 114.1, 127.5, 148.8, 133.5,0],
    [35, 142.8, 133.8, 133.6, 126.8,0],
    [36, 147.9, 151.0, 158.4, 107.1,0],
    [37, 123.8, 155.4, 134.3, 120.0,0],
    [38, 129.3, 140.0, 133.3, 139.5,0],
    [39, 157.6, 150.5, 144.5, 142.5,0],
    [40, 140.1, 153.8, 154.3, 136.6,0],
    [41, 151.8, 152.2, 135.3, 118.1,0],
    [42, 161.5, 150.2, 123.0, 110.6,0],
    [43, 171.8, 140.2, 149.8, 148.0,0],
    [44, 175.5, 162.5, 165.6, 116.7,0],
    [45, 170.5, 154.5, 149.0, 141.3,0],
    [46, 141.6, 173.4, 151.1, 144.0,0],
    [47, 181.0, 158.8, 141.6, 163.7,0],
    [48, 167.7, 170.6, 177.1, 142.6,0],
    [49, 197.8, 196.6, 187.6, 160.1,0],
    [50, 177.4, 179.5, 173.9, 168.5,0],
    [51, 186.6, 199.0, 159.9, 168.8,0],
    [52, 188.2, 195.8, 190.0, 156.7,0],
    [53, 0, 0, 0, 0, 0],
];

$helper = new HelperBoende(); // Create an instance of the HelperBoende class

    foreach ($data as $item) {
        $entity = new Boende();
        $helper->setData($item, $entity); // Use the setData method to set the data

        $this->entityManager->persist($entity);
    }

    $this->entityManager->flush();

    // Get the data
    $data = $boendeRepository->findAll();

    // Transform the data into separate items
    $formattedData = [];
    foreach ($data as $item) {
        $formattedData[] = $helper->getData($item); // Use the getData method to retrieve the data
    }

    return $this->render('show_all.statistics3.html.twig', ['formattedData' => $formattedData]);
}



#[Route('/proj/unemployement', name: 'statisticsUnenployement')]
public function unemployementizualizersecond(UnemploymentRepository $unenployementRepository): Response
{
    $this->entityManager->createQuery('DELETE FROM App\Entity\Unemployement')->execute();
    
    // Set the data
    $data = [
    ['15-19 år', 34.7, 37.1, 48.1],
    ['20-24 år', 14.1, 15.7, 21.1],
    ['25-34 år', 6.9, 6.2, 9.0],
    ['35-44 år', 5.0, 4.5, 6.0],
    ['45-54 år', 4.0, 4.4, 5.3],
    ['55-64 år', 4.5, 4.5, 5.4],
    ];


    $helper = new UnemployementHelper(); // Create an instance of the HelperBoende class

    foreach ($data as $item) {
        $entity = new Unemployement();
        $helper->setUnemployemntData($item, $entity); // Use the setData method to set the data

        $this->entityManager->persist($entity);
    }

    $this->entityManager->flush();

    // Get the data
    $data = $unenployementRepository->findAll();

    // Transform the data into separate items
    $formattedData = [];
    foreach ($data as $item) {
        $formattedData[] = $helper->formatUnemploymentData($item); // Use the getData method to retrieve the data
    }

    return $this->render('show_all.statistics4.html.twig', ['formattedData' => $formattedData]);
}

#[Route("/proj/api/effekt_av_covid19", name: "api_effekt_av_covid19")]
    public function getEffektAvCovid19Data(EffektAvCovid19Repository $effektAvCovid19Repository): JsonResponse
    {
        $data = $effektAvCovid19Repository->findAll();
        $formattedData = $this->effektAvCovid19Helper->formatEffektAvCovid19Data($data);

        return new JsonResponse($formattedData);
    }


    #[Route('/proj/api/boende', name: 'api_boende')]
public function getBoendeApi(BoendeRepository $boendeRepository): JsonResponse
{
    $data = $boendeRepository->findAll();
    $formattedData = [];
    $helper = new HelperBoende();

    foreach ($data as $item) {
        $formattedData[] = $helper->getData($item);
    }

    return new JsonResponse($formattedData);
}

#[Route('/proj/api/unemployment', name: 'api_unemployment')]
public function getUnemploymentApi(UnemploymentRepository $unemploymentRepository): JsonResponse
{
    $data = $unemploymentRepository->findAll();
    $formattedData = [];
    $helper = new UnemployementHelper();

    foreach ($data as $item) {
        $formattedData[] = $helper->formatUnemploymentData($item);
    }

    return new JsonResponse($formattedData);

}

#[Route("/proj/api/covid19/{total_deaths}", name: "api_total_deaths")]
public function getEffektAvCovid19DataByTotalDeaths(int $total_deaths,EffektAvCovid19Repository $effektAvCovid19Repository): JsonResponse
{
    $post = $effektAvCovid19Repository->findOneBy(['total_deaths' => $total_deaths]);

    if (!$post) {
        return new JsonResponse(['error' => 'Post not found.'], JsonResponse::HTTP_NOT_FOUND);
    }

    $response = [
                'deaths' => $post->getTotal_deaths(),
            ];
            return $this->json($response);
        }



#[Route("/proj/api/covid19Female/{female_deaths}", name: "api_female_deaths")]
public function getEffektAvCovid19Datafemale_deaths(int $female_deaths, EffektAvCovid19Repository $effektAvCovid19Repository): JsonResponse
{
    $post = $effektAvCovid19Repository->findOneBy(['female_deaths' => $female_deaths]);

    if (!$post) {
        return new JsonResponse(['error' => 'Post not found.'], JsonResponse::HTTP_NOT_FOUND);
    }

    $response = [
                'deaths' => $post->getFemale_Deaths(),
            ];
            return $this->json($response);
        }

#[Route("/proj/api/boende/{Vecka}", name: "api_boende_deaths_v")]
public function getBoendeApiBy(int $Vecka, BoendeRepository $boendeRepository): JsonResponse
{
    $post = $boendeRepository->findOneBy(['Vecka' => $Vecka]);

    if (!$post) {
        return new JsonResponse(['error' => 'Post not found.'], JsonResponse::HTTP_NOT_FOUND);
    }

    $response = [
        'Vecka' => $post->getVecka(),
        'twthousandsixteen' => $post->getTwthousandsixteen(),
        'twothousandseventeen' => $post->getTwothousandseventeen(),
        'twothousandeighteen' => $post->getTwothousandeighteen(),
        'twothousandnineteen' => $post->getTwothousandnineteen(),
        'twothousandtwenty' => $post->getTwothousandtwenty(),
    ];

    return $this->json($response);
}



#[Route("/proj/api/boendeAgeRange/{ageRange}", name: "api_unemployement_age")]
public function getUnemployementApiBy(string $ageRange, UnemploymentRepository $unemploymentRepository): JsonResponse
{
    $post = $unemploymentRepository->findOneBy(['ageRange' => $ageRange]);

    if (!$post) {
        return new JsonResponse(['error' => 'Post not found.'], JsonResponse::HTTP_NOT_FOUND);
    }

    $response = [
        'ageRange' => $post->getAgeRange(),
        'age2018' => $post->getAge2018(),
        'age2019' => $post->getAge2019(),
        'age2020' => $post->getAge2020(),
    ];

    return $this->json($response);
}

#[Route('/proj/reset', name: 'proj_reset')]
    public function resetDatabase(EntityManagerInterface $entityManager): Response
    {
        $connection = $entityManager->getConnection();
        $platform = $connection->getDatabasePlatform();

        $connection->executeStatement($platform->getTruncateTableSQL(' effekt_av_covid19', true /* whether to cascade */));
        $connection->executeStatement($platform->getTruncateTableSQL(' boende', true /* whether to cascade */));
        $connection->executeStatement($platform->getTruncateTableSQL(' unemployement', true /* whether to cascade */));

        // Add code to reset other tables if needed

        return $this->redirectToRoute('proj');
    }

}



