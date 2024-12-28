<?php

namespace App\Controller;

use App\Entity\Album;
use App\Repository\AlbumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AlbumController extends AbstractController
{
    #[Route('/albums', name: 'app_album_list', methods: ['GET'])]
    public function index(AlbumRepository $albumRepository): Response
    {
        $albumArr = $albumRepository->listAlbum();

        return $this->render('album/list_album.html.twig', [
            'albums' => $albumArr,
        ]);
    }

    #[Route('/album/{id} ', name: 'app_album', methods: ['GET'])]
    public function Album(Album $album): Response
    {
        return $this->render('album/album.html.twig', [
            'album' => $album,
        ]);
    }
}
