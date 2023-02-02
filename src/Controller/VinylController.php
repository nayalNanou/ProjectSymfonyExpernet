<?php
namespace App\Controller;

use Twig\Environment;
use Psr\Cache\CacheItemInterface;
use function Symfony\Component\String\u;
use Symfony\Contracts\Cache\CacheInterface;
use Knp\Bundle\TimeBundle\DateTimeFormatter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VinylController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function homepage(Environment $myTwig): Response
    {
        return new Response(
            $myTwig->render('homepage.html.twig', [
                'songs' => $this->getSongsTitles()
            ])
        );
    }

    #[Route('/browse/{slug}', name: 'browse')]
    public function browse(CacheInterface $cache, DateTimeFormatter $formatter, HttpClientInterface $client, string $slug = '')
    {
        $mixes = $cache->get('mixes_data', function(CacheItemInterface $cacheItem) use ($client) {
            $cacheItem->expiresAfter(5);

            $response = $client->request(
                'GET',
                'https://raw.githubusercontent.com/SymfonyCasts/vinyl-mixes/main/mixes.json'
            );
            return $response->toArray();
        });

        $genre = $slug ? u(str_replace('-', ' ', $slug))->title(true) : null;

        return $this->render('vinyl/browse.html.twig', [
            'mixes' => $mixes,
            'genre' => $genre 
        ]); 
    }

    public function getSongsTitles()
    {
        return [
            "Gangsta's Paradise - Coolio",
            "Waterfalls - TLC",
            "Creep - TLC",
            "Kiss from a Rose - Seal",
            "On Bended Knee - Boyz II Men",
            "Another Night - Real McCoy",
            "Fantasy - Mariah Carey",
            "Take a Bow - Madonna",
            "Miley Cyrus - ######"
        ];
    }

    private function getMixes(): array 
    { 
        // temporary fake "mixes" data 

        return [ 
            [ 
                'title' => 'PB & Jams', 
                'trackCount' => 14, 
                'genre' => 'Rock', 
                'createdAt' => new \DateTime('2021-10-02'), 
            ], 
            [ 
                'title' => 'Put a Hex on your Ex', 
                'trackCount' => 8, 
                'genre' => 'Heavy Metal', 
                'createdAt' => new \DateTime('2022-04-28'), 
            ], 
            [ 
                'title' => 'Spice Grills - Summer Tunes', 
                'trackCount' => 10, 
                'genre' => 'Pop', 
                'createdAt' => new \DateTime('2019-06-20'), 
            ]
        ]; 
    } 
}
