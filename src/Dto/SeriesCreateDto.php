<?php

namespace App\Dto;

class SeriesCreateDto
{
    public string $name;
    public int $seasons;
    public int $episodesPerSeason;

    public function __construct(string $name, int $seasons, int $episodesPerSeason)
    {
        $this->name = $name;
        $this->seasons = $seasons;
        $this->episodesPerSeason = $episodesPerSeason;
    }


}