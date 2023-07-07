<?php

namespace App\MessageHandler;

use App\Message\SeriesWasDeleted;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class DeleteSeriesCoverHandler
{
    private ParameterBagInterface $parameterBag;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
    }

    public function __invoke(SeriesWasDeleted $message): void
    {
        $coverImagePath = $message->series->getCoverImagePath();
        unlink($this->parameterBag->get('cover_image_directory') . DIRECTORY_SEPARATOR . $coverImagePath);
    }
}