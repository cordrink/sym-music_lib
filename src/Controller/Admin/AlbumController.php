<?php

namespace App\Controller\Admin;

use App\Entity\Album;
use App\Form\AlbumType;
use App\Repository\AlbumRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AlbumController extends AbstractController
{
    #[Route('/admin/albums', name: 'admin_album_list', methods: ['GET'])]
    public function index(AlbumRepository $albumRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $albumArray = $paginator->paginate(
            $albumRepository->listAlbum(), /* query NOT result */
            $request->query->getInt('page', 1), /* page number */
            8 /* limit per page */
        );

        return $this->render('admin/album/list_album.html.twig', [
            'albumList' => $albumArray,
        ]);
    }

    #[Route('/admin/albums/ajout', name: 'admin_album_add', methods: ['GET', 'POST'])]
    #[Route('/admin/albums/modif/{id}', name: 'admin_album_update', methods: ['GET', 'POST'])]
    public function addUpdateAlbum(EntityManagerInterface $manager, Request $request, Album $album = null): Response
    {
        if ($album == null) {
            $album = new Album();
            $mode = "ajoute";
        } else {
            $mode = "modifie";
        }

        $formAlbum = $this->createForm(AlbumType::class, $album);

        $formAlbum->handleRequest($request);

        if ($formAlbum->isSubmitted() && $formAlbum->isValid()) {

            $imageUrl = $formAlbum->getData()->getImageUrl();

            if ($imageUrl == null) {
                $album->setImageUrl("https://previews.123rf.com/images/kannaa123rf/kannaa123rf1608/kannaa123rf160800029/61248392-r%C3%A9sum%C3%A9-fond-musical-avec-disque-vinyle-disque-album-lp-notes-noires-isol%C3%A9-sur-fond-blanc-vector.jpg");
            }


            //dd($formAlbum->getData()->getId());

            $manager->persist($album);
            $manager->flush();

            $this->addFlash('success', "L'album a bien ete $mode");
            return $this->redirectToRoute('admin_album_list');
        }

        return $this->render('admin/album/addUpdate_album.html.twig', [
            'formAlbum' => $formAlbum->createView(),
        ]);
    }

    #[Route('/admin/albums/supprimer/{id}', name: 'admin_album_delete', methods: ['GET', 'POST'])]
    public function deleteAlbum(EntityManagerInterface $manager, Album $album): Response
    {
        $nbPiece = $album->getPieces()->count();
        $nameAlbum = $album->getName();

        if ($nbPiece > 0) {
            $this->addFlash('danger', "Vous ne pouvez pas supprimer $nameAlbum car il possede $nbPiece morceaux");
        } else {
            $manager->remove($album);
            $manager->flush();

            $this->addFlash('success', "L'album a bien ete supprime");
        }

        return $this->redirectToRoute('admin_album_list');

    }
}
