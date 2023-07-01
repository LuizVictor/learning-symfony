<?php

namespace App\Controller;

use App\Entity\Series;
use App\Repository\SeriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SeriesController extends AbstractController
{
    private SeriesRepository $seriesRepository;

    public function __construct(SeriesRepository $seriesRepository)
    {
        $this->seriesRepository = $seriesRepository;
    }

    #[Route('/series', name: 'app_series', methods: ['GET'])]
    public function index(): Response
    {
        $seriesList = $this->seriesRepository->findAll();

        return $this->render('series/index.html.twig', [
            'seriesList' => $seriesList,
        ]);
    }

    #[Route('/series/create', name: 'app_series_create', methods: ['GET'])]
    public function create(): Response
    {
        return $this->render('series/create.html.twig');
    }

    #[Route('/series/create', name: 'app_series_store', methods: ['POST'])]
    public function store(Request $request): Response
    {
        $name = $request->request->get('name');
        $serie = new Series($name);

        $this->seriesRepository->save($serie, true);
        return new RedirectResponse('/series');
    }

    #[Route('/series/destroy/{id}', name: 'app_series_destroy', methods: ['DELETE'])]
    public function destroy(int $id): Response
    {
        $serie = $this->seriesRepository->findByIdPartial($id);
        $this->seriesRepository->remove($serie, true);
        return new RedirectResponse('/series');
    }
}
