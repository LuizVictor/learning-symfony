<?php

namespace App\Message;

use App\Entity\Series;

class SeriesWasCreated
{
    public readonly Series $series;

    public function __construct(Series $series)
    {
        $this->series = $series;
    }
}