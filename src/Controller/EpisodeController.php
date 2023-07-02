<?php

namespace App\Controller;

use App\Entity\Season;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EpisodeController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/season/{season}/episode', name: 'app_episode', methods: ['GET'])]
    public function index(Season $season): Response
    {
        return $this->render('episode/index.html.twig', [
            'series' => $season->getSeries(),
            'season' => $season,
            'episodes' => $season->getEpisodes()
        ]);
    }

    #[Route('/season/{season}/episode', name: 'app_watch_episode', methods: ['POST'])]
    public function watch(Season $season, Request $request): Response
    {
        $watched = array_keys($request->request->all('episode'));
        $episodes = $season->getEpisodes();

        foreach ($episodes as $episode) {
            $episode->setWatched(in_array($episode->getId(), $watched));
        }

        $this->entityManager->flush();

        return new RedirectResponse("/season/{$season->getId()}/episode");
    }
}
