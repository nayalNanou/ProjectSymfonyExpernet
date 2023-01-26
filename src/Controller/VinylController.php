<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VinylController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function homepage(): Response
    {
        return new Response('PHP EIYUU');
    }

    #[Route('/browse', name: 'browse')]
    public function browse(): Response
    {
        return new Response('Tous les genres');
    }

    #[Route('/browse/{randomGenre}', name: 'browse_genre')]
    public function browseGenre(string $randomGenre): Response
    {
        return new Response($randomGenre);
    }
}