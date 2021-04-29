<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RedocController extends AbstractController
{
    /**
     * @Route("/api/doc", name="api_doc_redoc")
     */
    public function index()
    {
        return $this->render('api/doc/redoc.html.twig');
    }
}