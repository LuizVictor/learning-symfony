<?php

namespace App\Controller;

use App\Entity\Series;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SeasonController extends AbstractController
{
    #[Route('/series/{series}/season', name: 'app_season', methods: ['GET'])]
    public function index(Series $series): Response
    {
        $seasonList = $series->getSeasons();

        return $this->render('season/index.html.twig', [
            'seasonList' => $seasonList,
            'series' => $series
        ]);
    }
}
