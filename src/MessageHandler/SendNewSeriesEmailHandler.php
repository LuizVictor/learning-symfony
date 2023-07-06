<?php

namespace App\MessageHandler;

use App\Entity\User;
use App\Message\SeriesWasCreated;
use App\Repository\UserRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class SendNewSeriesEmailHandler
{
    private UserRepository $userRepository;
    private MailerInterface $mailer;

    public function __construct(UserRepository $userRepository, MailerInterface $mailer)
    {
        $this->userRepository = $userRepository;
        $this->mailer = $mailer;
    }

    public function __invoke(SeriesWasCreated $message)
    {
        $users = $this->userRepository->findAll();
        $usersEmail = array_map(fn(User $user) => $user->getEmail(), $users);
        $series = $message->series;

        $email = (new TemplatedEmail())
            ->from('hello@example.com')
            ->to(...$usersEmail)
            ->subject('New Series created')
            ->text("Series {$series->getName()} created!")
            ->htmlTemplate("emails/series-created.html.twig")
            ->context(compact('series'));

        $this->mailer->send($email);
    }
}