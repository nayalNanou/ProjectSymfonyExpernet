<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Psr\Log\LoggerInterface;

class SongApiController extends AbstractController
{
    #[Route('/api/songs/{id<^[0-9]+$>}', name: 'song_api')]
    public function apiSongs(int $id, LoggerInterface $logger): Response
    {
        $logger->info('Returning API response for song '. $id);

        $song = [ 
            'id' => $id, 
            'name' => 'Waterfalls', 
            'url' => 'https://symfonycasts.s3.amazonaws.com/sample.mp3', 
        ];

        return new JsonResponse($song);
    }
}