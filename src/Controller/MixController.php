<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\VinylMix;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Psr\Cache\CacheItemInterface;
use function Symfony\Component\String\u;

class MixController extends AbstractController
{
    #[Route('/browse/{slug}', name: 'browse')]
    public function browse(EntityManagerInterface $em, CacheInterface $cache, HttpClientInterface $client, string $slug = ''): Response
    {
        $mixes = $cache->get('mixes_data', function(CacheItemInterface $cacheItem) use ($client, $em, $slug) {
            $cacheItem->expiresAfter(1);

            $vinylMixRepository = $em->getRepository(VinylMix::class);

            return $vinylMixRepository->filterByGenre($slug);
        });

        $genre = $slug ? u(str_replace('-', ' ', $slug))->title(true) : null;

dump($mixes);

        return $this->render('mix/browse.html.twig', [
            'mixes' => $mixes,
            'genre' => $genre 
        ]); 
    }

    #[Route('/mix/new', name: 'mix_new')]
    public function new(EntityManagerInterface $entityManager): Response
    {
        $titles = [
            'Sarah -  Master For A Living',
            'John - Crazy Of Words',
            'Cloe - Minute Of The Good Life',
            'Mia - Power For Money',
            'Henry -  Forget My Darling',
            'Ben - Thoughts Of My Heartbeat',
            'Marie - Risky And Moves',
            'Joseph -  Broken And Danger'
        ];
        $genres = ['R&B', 'Pop', 'Rap', 'Country', 'Dubstep', 'Rock', 'Heavy Metal', 'Classical'];

        $mix = new VinylMix;
        $mix->setTitle($titles[rand(0, count($titles) - 1)])
            ->setDescription('No description')
            ->setTrackCount(rand(0, 10))
            ->setVotes(rand(-10, 10))
            ->setGenre($genres[rand(0, count($genres) - 1)]);

        $entityManager->persist($mix);
        $entityManager->flush();

        dd($mix);
    }

    #[Route('/mix/{id}/vote', name: 'mix_vote', methods: "POST")]
    public function vote(VinylMix $mix, Request $request, EntityManagerInterface $entityManager): Response
    {
        $thumb = $request->request->get('direction');

        if ($thumb == 'up') {
            $mix->setVotes($mix->getVotes() + 1);
        } else {
            $mix->setVotes($mix->getVotes() - 1);
        }

        $entityManager->persist($mix);
        $entityManager->flush($mix);

        $this->addFlash('success', 'Le vote a bien été pris en compte');

        return $this->redirectToRoute('mix_show', ['id' => $mix->getId()]);
    }

    #[Route('/mix/{id}', name: 'mix_show')]
    public function show(VinylMix $mix): Response
    {
        return $this->render('mix/show.html.twig', [
            'mix' => $mix
        ]);
    }
}