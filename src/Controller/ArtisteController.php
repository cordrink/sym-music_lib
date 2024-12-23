<?php

namespace App\Controller;

use App\Repository\ArtisteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ArtisteController extends AbstractController
{
    #[Route('/artistes', name: 'app_artiste',methods: 'GET')]
    public function index(ArtisteRepository $artisteRepository): Response
    {
        $artisteArr = $artisteRepository->findAll();

        return $this->render('artiste/index.html.twig', [
            'artisteArr' => $artisteArr,
        ]);
    }
}
