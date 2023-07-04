<?php

namespace App\Controller;

use App\Dto\SeriesCreateDto;
use App\Entity\Episode;
use App\Entity\Season;
use App\Entity\Series;
use App\Form\SeriesCreateType;
use App\Repository\SeriesRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class SeriesController extends AbstractController
{
    private SeriesRepository $seriesRepository;
    private MailerInterface $mailer;

    public function __construct(SeriesRepository $seriesRepository, MailerInterface $mailer)
    {
        $this->seriesRepository = $seriesRepository;
        $this->mailer = $mailer;
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
        $dto = new SeriesCreateDto('', 0, 0);
        $form = $this->createForm(SeriesCreateType::class, $dto);
        return $this->render('series/form.html.twig', [
            'title' => 'New series',
            'form' => $form,
            'btn_text' => 'Create',
        ]);
    }

    #[Route('/series/create', name: 'app_series_store', methods: ['POST'])]
    public function store(Request $request): Response
    {
        $input = new SeriesCreateDto('', 0, 0);
        $form = $this->createForm(SeriesCreateType::class, $input)->handleRequest($request);

        if (!$form->isValid()) {
            return $this->render('series/form.html.twig', [
                'title' => 'New series',
                'form' => $form
            ]);
        }

        $series = new Series($input->name);
        $this->addSeasons($input, $series);

        $user = $this->getUser();

        $email = (new TemplatedEmail())
            ->from('hello@example.com')
            ->to($user->getUserIdentifier())
            ->subject('New Series created')
            ->text("Series {$series->getName()} created!")
            ->htmlTemplate("emails/series-created.html.twig")
            ->context(compact('series'));

        $this->mailer->send($email);

        $this->addFlash('success', 'Series created with success');

        $this->seriesRepository->save($series, true);
        return new RedirectResponse('/series');
    }

    #[Route('/series/edit/{series}', name: 'app_series_edit', methods: ['GET'])]
    public function edit(Series $series): Response
    {
        return $this->render('series/form.html.twig', [
            'title' => 'Edit series',
            'series' => $series
        ]);
    }

    #[Route('/series/edit/{series}', name: 'app_series_update', methods: ['PUT'])]
    public function update(Series $series, Request $request): Response
    {
        $name = $request->request->get('name');
        $this->seriesRepository->update($series, $name);
        $this->addFlash('success', 'Series updated with success');

        return new RedirectResponse('/series');
    }

    #[Route('/series/destroy/{id}', name: 'app_series_destroy', methods: ['DELETE'])]
    public function destroy(int $id): Response
    {
        $series = $this->seriesRepository->findByIdPartial($id);
        $this->seriesRepository->remove($series, true);
        $this->addFlash('success', 'Series removed with success');

        return new RedirectResponse('/series');
    }

    private function addSeasons(SeriesCreateDto $input, Series $series): void
    {
        for ($i = 1; $i <= $input->seasons; $i++) {
            $season = new Season($i);
            $this->addEpisodes($input, $season);
            $series->addSeason($season);
        }
    }

    private function addEpisodes(SeriesCreateDto $input, Season $season): void
    {
        for ($i = 1; $i <= $input->episodesPerSeason; $i++) {
            $season->addEpisode(new Episode($i));
        }
    }
}
