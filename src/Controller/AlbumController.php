<?php

namespace App\Controller;

use App\Entity\Album;
use App\Model\FilterAlbum;
use App\Repository\AlbumRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AlbumController extends AbstractController
{
    #[Route('/albums', name: 'app_album_list', methods: ['GET'])]
    public function index(AlbumRepository $albumRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $filter = new FilterAlbum();

        $query = $albumRepository->listAlbum($filter);

        $albumArr = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /* page number */
            8 /* limit per page */
        );

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
