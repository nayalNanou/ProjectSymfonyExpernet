<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use function Symfony\Component\String\u;
use Twig\Environment;

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
    public function browse($slug = '')
    {
        $genre = $slug ? u(str_replace('-', ' ', $slug))->title(true) : null;

        return $this->render('vinyl/browse.html.twig', [
            'mixes' => $this->getMixes(),
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
