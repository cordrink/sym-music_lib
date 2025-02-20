<?php

namespace App\Model;

use App\Entity\Artiste;
use App\Entity\Style;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

class FilterAlbum
{

    #[Assert\Length(
        min: 2,
        minMessage: "Le nom de l'album doit comporter au minimum {{ limit }} caracteres",
    )]
    public string $name;

    public Artiste $artist;

    /**
     * @var Collection<Style>
     */
    public Collection $styles;

    public function __construct()
    {
        $this->styles = new ArrayCollection();
    }

}