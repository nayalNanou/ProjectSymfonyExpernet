<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use function Symfony\Component\String\u;

class VinylController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function homepage(): Response
    {
        return $this->render('homepage.html.twig', [
            'songs' => $this->getSongsTitles()
        ]);
    }

    #[Route('/browse/{slug}', name: 'browse')]
    public function browse($slug = '')
    {
        $genre = $slug ? u(str_replace('-', ' ', $slug))->title(true) : null;

        return $this->render('vinyl/browse.html.twig', [ 
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
}
