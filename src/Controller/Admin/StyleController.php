<?php

namespace App\Controller\Admin;

use App\Entity\Style;
use App\Form\StyleType;
use App\Repository\StyleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StyleController extends AbstractController
{
    #[Route('/admin/styles', name: 'admin_styles')]
    public function index(StyleRepository $styleRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $styleArr = $paginator->paginate(
            $styleRepository->listStyle(), /* query NOT result */
            $request->query->getInt('page', 1), /* page number */
            8 /* limit per page */
        );

        return $this->render('admin/style/list_style.html.twig', [
            'styleArr' => $styleArr,
        ]);
    }

    #[Route('/admin/styles/ajout', name: 'admin_styles_add', methods: ['GET', 'POST'])]
    #[Route('/admin/styles/modification/{id}', name: 'admin_styles_update', methods: ['GET', 'POST'])]
    public function addUpdateStyle(Request $request, EntityManagerInterface $manager, Style $style = null): Response
    {
        if ($style === null) {
            $style = new Style();
            $mode = "ajoute`";
        } else {
            $mode = "modifie`";
        }


        $formStyle = $this->createForm(StyleType::class, $style);
        $formStyle->handleRequest($request);

//        dd($formStyle);

        if ($formStyle->isSubmitted() && $formStyle->isValid()) {
            $manager->persist($style);
            $manager->flush();

            $this->addFlash("success", "Nouveau style $mode avec succes");

            return $this->redirectToRoute('admin_styles');
        }

        return $this->render('admin/style/addUpdate_style.html.twig', [
            'formStyle' => $formStyle->createView(),
        ]);
    }

    #[Route('/admin/styles/supp/{id}', name: 'admin_styles_delete', methods: ['GET'])]
    public function deleteStyle(EntityManagerInterface $manager, Style $style): Response
    {
        $nbAlbum = $style->getAlbums()->count();
        $styleName = $style->getName();

        if ($nbAlbum > 0) {
            $this->addFlash("danger", "Le style $styleName ne peut pas etre supprime car il est lie` a $nbAlbum albums");
        } else {
        $manager->remove($style);
        $manager->flush();

        $this->addFlash("success", "Style supprime` avec succes");
        }

        return $this->redirectToRoute('admin_styles');
    }
}
