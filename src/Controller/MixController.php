<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\VinylMix;

class MixController extends AbstractController
{
    #[Route('/mix/new', name: 'mix_new')]
    public function new(EntityManagerInterface $entityManager)
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

    #[Route('/mix/{id}', name: 'mix_show')]
    public function show(int $id, EntityManagerInterface $entityManager)
    {
        $mix = $entityManager->getRepository(VinylMix::class)->find($id);

        dd($mix);
    }
}