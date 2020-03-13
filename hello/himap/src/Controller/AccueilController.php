<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
    *Fonction permettant de visiualiser la page d'accueil du site web
    * @author CHABOUR Lina ij00898
    * @version 1.0 
    * date 05-03-2020
     * @Route("/", name="accueil")
     */
    public function index()
    {
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }
}
