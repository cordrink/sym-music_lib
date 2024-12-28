<?php

namespace App\Controller;

use App\Entity\Artiste;
use App\Repository\ArtisteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ArtisteController extends AbstractController
{
    #[Route('/artistes', name: 'app_artiste',methods: 'GET')]
    public function index(ArtisteRepository $artisteRepository): Response
    {
        $artisteArr = $artisteRepository->listArtiste();

        return $this->render('artiste/list_artist.html.twig', [
            'artisteArr' => $artisteArr,
        ]);
    }

    #[Route('/artiste/{id}', name: 'ficheArtiste',methods: 'GET')]
    public function ficheArtiste(Artiste $artiste): Response
    {
        return $this->render('artiste/fiche_artist.html.twig', [
            'artisteObj' => $artiste,
        ]);
    }
}
