<?php

namespace App\Message;

use App\Entity\Series;

class SeriesWasDeleted
{
    public readonly Series $series;

    public function __construct(Series $series)
    {
        $this->series = $series;
    }


}