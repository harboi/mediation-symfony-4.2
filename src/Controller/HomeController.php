<?php

namespace App\Controller;

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
        return $this->render('index.html.twig');
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
     * @Route("/particulier", name="particulier")
     * @return Response
     */
    public function particulier()
    {
        return $this->render('particulier.html.twig');
    }

    /**
     * @Route("/entreprise", name="entreprise")
     * @return Response
     */
    public function entreprise()
    {
        return $this->render('entreprise.html.twig');
    }

    /**
     * @Route("/publications", name="publications")
     * @return Response
     */
    public function publications()
    {
        return $this->render('publications.html.twig');
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
     * @Route("/contact", name="contact")
     * @return Response
     */
    public function contact()
    {
        return $this->render('contact.html.twig');
    }

}
