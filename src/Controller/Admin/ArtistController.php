<?php

namespace App\Controller\Admin;

use App\Entity\Artiste;
use App\Form\ArtistType;
use App\Repository\ArtisteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ArtistController extends AbstractController
{
    #[Route('/admin/artistes', name: 'admin_artist')]
    public function index(ArtisteRepository $artisteRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $artisteArr = $paginator->paginate(
            $artisteRepository->listArtisteAdmin(), /* query NOT result */
            $request->query->getInt('page', 1), /* page number */
            8 /* limit per page */
        );

        return $this->render('admin/artist/list_artist.html.twig', [
            'artisteArr' => $artisteArr,
        ]);
    }


    #[Route('/admin/artiste/ajout', name: 'admin_artist_add', methods: ['GET', 'POST'])]
    #[Route('/admin/artiste/modif/{id}', name: 'admin_artist_update', methods: ['GET', 'POST'])]
    public function addUpdateArtist(Request $request, EntityManagerInterface $manager, Artiste $artiste = null): Response
    {
        if ($artiste == null) {
            $artiste = new Artiste();
            $mode = "ajoute";
        } else {
            $mode = "modifie";
        }

        $form = $this->createForm(ArtistType::class, $artiste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //dd($artiste);

            $manager->persist($artiste);
            $manager->flush();

            $this->addFlash('success', "L'artiste a bien ete $mode");

            return $this->redirectToRoute('admin_artist');
        }

        return $this->render('admin/artist/addUpdateArtist.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/admin/artiste/suppression/{id}', name: 'admin_artist_delete', methods: ['GET'])]
    public function delArtist(EntityManagerInterface $manager, Artiste $artiste): Response
    {
        //dd($artiste);
        $nbAlbums = $artiste->getAlbums()->count();
        $nameArtiste = $artiste->getName();

        if ($nbAlbums > 0) {
            $this->addFlash('danger', "Vous ne pouvez pas supprimer $nameArtiste car il possede $nbAlbums albums");
        } else {
            $manager->remove($artiste);
            $manager->flush();

            $this->addFlash('success', "L'artiste a bien ete supprime");
        }

        return $this->redirectToRoute('admin_artist');
    }
}
