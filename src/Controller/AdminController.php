<?php

namespace App\Controller;

use App\Entity\Publication;
use App\Entity\Publication\Repository\Exception\PublicationNotFound;
use App\Form\PublicationForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/administration")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="adminIndex")
     * @return RedirectResponse
     */
    public function index()
    {
        return $this->redirect($this->generateUrl('adminPublications'));
    }

    /**
     * @Route("/publication/list", name="adminPublications")
     * @return Response
     */
    public function listPublications()
    {
        /** @var  \App\Repository\PublicationRepository $repo */
        $repo = $this->getDoctrine()->getManager()->getRepository(Publication::class);
        try {
            $list = $repo->getList();
        } catch (PublicationNotFound $e) {
            $list = null;
        } catch (\Exception $e) {
            return new Response('Erreur côté serveur, contactez l\'administrateur', 500);
        }

        return $this->render('Admin/publications.html.twig', ['publications' => $list]);
    }


    /**
     * @Route("/publication/create", name="adminAddPublication", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function addPublicationAction(Request $request)
    {
        $publication = new Publication();
        try {
            $publication->setPublishedAt(new \DateTime());
        } catch (\Exception $e) {
            throw new \Error();
        }

        $form = $this->createForm(PublicationForm::class, $publication);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                /** @var  \App\Repository\PublicationRepository $repo */
                $repo = $this->getDoctrine()->getManager()->getRepository(Publication::class);
                $repo->save($publication);
            } catch (\Exception $e) {
                $this->addFlash('error', 'Erreur lors de la sauvegarde');
                return $this->redirect($this->generateUrl('adminPublications'));
            }
            $this->addFlash('success', 'La publication a bien été enregistrée');
            return $this->redirect($this->generateUrl('adminPublications'));
        }

        return $this->render('Form/publication.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route(
     *       path         = "/publication/{id}/edit",
     *       name         = "adminEditPublication",
     *       requirements = { "id" = "[0-9]+" },
     *       methods      = { "GET", "POST" }
     * )
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editPublicationAction(Request $request, $id)
    {
        try {
            /** @var  \App\Repository\PublicationRepository $repo */
            $repo = $this->getDoctrine()->getManager()->getRepository(Publication::class);
            $publication = $repo->findById($id);
        } catch (\Exception $e) {
            $this->addFlash('error', 'Erreur : publication introuvable');
            return $this->redirect($this->generateUrl('adminPublications'));
        }

        $form = $this->createForm(PublicationForm::class, $publication);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                /** @var  \App\Repository\PublicationRepository $repo */
                $repo = $this->getDoctrine()->getManager()->getRepository(Publication::class);
                $repo->save($publication);
            } catch (\Exception $e) {
                $this->addFlash('error', 'Erreur lors de la sauvegarde');
                return $this->redirect($this->generateUrl('adminPublications'));
            }
            $this->addFlash('success', 'La publication a bien été enregistrée');
            return $this->redirect($this->generateUrl('adminPublications'));
        }

        return $this->render('Form/publication.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route(
     *       path         = "/publication/{id}/delete",
     *       name         = "adminDeletePublication",
     *       requirements = { "id" = "[0-9]+" },
     *       methods      = { "GET" }
     * )
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function deletePublicationAction($id)
    {
        try {
            /** @var  \App\Repository\PublicationRepository $repo */
            $repo = $this->getDoctrine()->getManager()->getRepository(Publication::class);
            $publication = $repo->findById($id);
            $repo->delete($publication);
            $this->addFlash('success', 'La publication a bien été supprimée');
        } catch (\Exception $e) {
            $this->addFlash('error', 'Erreur lors de la suppression');
        }

        return $this->redirect($this->generateUrl('adminPublications'));
    }

}