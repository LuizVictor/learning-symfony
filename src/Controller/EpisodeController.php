<?php

namespace App\Controller;

use App\Entity\Season;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EpisodeController extends AbstractController
{
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
        dd($request->request->all('episode'));
    }
}
