<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SeriesController extends AbstractController
{
    #[Route('/series', name: 'app_series', methods: ['GET'])]
    public function index(): Response
    {
        $seriesList = [
            'Sopranos',
            'The Wire',
            'Breaking bad'
        ];

        return $this->render('series/index.html.twig', [
            'seriesList' => $seriesList,
        ]);
    }

    #[Route('/series/create', methods: ['GET'])]
    public function create(): Response
    {
        return $this->render('series/create.html.twig');
    }
}
