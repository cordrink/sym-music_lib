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
    public function addArtist(Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(ArtistType::class, new Artiste() );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //dd($artiste);

            $manager->persist($form->getData());
            $manager->flush();

            $this->addFlash('success',"L'artiste a bien ete ajoute");

            return $this->redirectToRoute('admin_artist');
        }

        return $this->render('admin/artist/addArtist.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/artiste/modif/{id}', name: 'admin_artist_update', methods: ['GET', 'POST'])]
    public function updateArtist(Artiste $artiste, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(ArtistType::class, $artiste );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //dd($artiste);

            $manager->persist($artiste);
            $manager->flush();

            $this->addFlash('success',"L'artiste a bien ete modifie");

            return $this->redirectToRoute('admin_artist');
        }

        return $this->render('admin/artist/updateArtist.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
