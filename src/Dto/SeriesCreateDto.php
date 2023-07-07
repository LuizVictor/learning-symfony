<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class SeriesCreateDto
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 5)]
    public string $name = '';
    #[Assert\Positive]
    public int $seasons;
    #[Assert\Positive]
    public int $episodesPerSeason;
    public ?string $coverImage;

    public function __construct(string $name = '', int $seasons = 0, int $episodesPerSeason = 0, string $coverImage = null)
    {
        $this->name = $name;
        $this->seasons = $seasons;
        $this->episodesPerSeason = $episodesPerSeason;
        $this->coverImage = $coverImage;
    }


}