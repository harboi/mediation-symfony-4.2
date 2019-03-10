<?php

namespace App\Controller;

use App\Entity\Publication;
use App\Entity\Publication\Repository\Exception\PublicationNotFound;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class HomeController  extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     * @return Response
     */
    public function index(): Response
    {
        /** @var  \App\Repository\PublicationRepository $repo */
        $repo = $this->getDoctrine()->getManager()->getRepository(Publication::class);
        try {
            $list = $repo->getTwoLast();
        } catch (PublicationNotFound $e) {
            $list = null;
        } catch (\Exception $e) {
            return new Response('Erreur côté serveur, contactez l\'administrateur', 500);
        }

        return $this->render('index.html.twig', ['publications' => $list]);
    }

    /**
     * @Route("/mediateur", name="mediateur")
     * @return Response
     */
    public function mediateur(): Response
    {
        return $this->render('mediateur.html.twig');
    }

    /**
     * @Route("/mediation-vs-procedure-judiciaire", name="mediation-vs-procedure-judiciaire")
     * @return Response
     */
    public function mediationVsJudiciaire()
    {
        return $this->render('mediation-vs-judiciaire.html.twig');
    }

    /**
     * @Route("/espace-particulier", name="particulier")
     * @return Response
     */
    public function particulier()
    {
        return $this->render('espace-particulier.html.twig');
    }

    /**
     * @Route("/entreprise", name="entreprise")
     * @return Response
     */
    public function entreprise()
    {
        return $this->render('espace-entreprise.html.twig');
    }

    /**
     * @Route("/publications", name="publications")
     * @return Response
     */
    public function publications()
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

        return $this->render('publications.html.twig', ['publications' => $list]);
    }

    /**
     * @Route(
     *       path         = "/publication/{id}",
     *       name         = "publication",
     *       requirements = { "id" = "[0-9]+" },
     *       methods      = { "GET", "POST" }
     * )
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function showPublication($id)
    {
        try {
            /** @var  \App\Repository\PublicationRepository $repo */
            $repo = $this->getDoctrine()->getManager()->getRepository(Publication::class);
            $publication = $repo->findById($id);
        } catch (\Exception $e) {
            $this->addFlash('error', 'Erreur : publication introuvable');
            return $this->redirect($this->generateUrl('publications'));
        }

        return $this->render('publication.html.twig', ['publication' => $publication]);
    }

    /**
     * @Route("/honoraires", name="honoraires")
     * @return Response
     */
    public function honoraires()
    {
        return $this->render('honoraires.html.twig');
    }

    /**
     * @Route("/deroulement-mediation", name="deroulement-mediation")
     * @return Response
     */
    public function deroulementMediation()
    {
        return $this->render('deroulement-mediation.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     * @return Response
     */
    public function contact()
    {
        return $this->render('contact.html.twig');
    }

}
