<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\SaisirAdresse;
use Symfony\Component\HttpFoundation\Request;
use App\Form\SaisieAdresseType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;



class AppController extends AbstractController
{


    /** Modification de la fonction index : Ajout de création de l'objet et vérification du formulaire ainsi
     * la récupération des données saisies par l'utilisateur 
    * @author CHABOUR Lina ij00898
    * @version 2.0 
    * date 13-03-2020
    * @Route("/app", name="app")
    */

    /**
    *Fonction permettant de visiualiser la page de l'application web
    * @author AIT HAMMOUDA Rayane ij07732
    * @version 1.0 
    * date 05-03-2020
    * @Route("/app", name="app")
    */
    
    

    public function index(Request $request)
    {
        //Creation de l'objet adresse qui va servir a la creation du formulaire
        $adresse= new SaisirAdresse();
        $form=$this->createForm(SaisieAdresseType::class,$adresse);
        $form->handleRequest($request);
        //verification de la validite et la soummision du formulaire saisie
        if ($form->isSubmitted() && $form->isValid())
         {
            //recuperation de l'adresse et du rayon saisie 
            $myData = $form->get('adresse')->getData();
            $transport=$form->get('transport')->getData();
            $temps=$form->get('temps')->getData();
            $heure = date("H:i");
            $date = date("d-m-Y");
            //stockage du rayon et l'adresse saisie dans une session 
            $session = $request->getSession();
            $session->set('adresse',$myData);
            $session->set('transport',$transport);
            $session->set('temps',$temps);
            $session->set('date',$date);
        
           $tableau = array(
            'date'=>$date,
            'transport'=>$transport,
            'temps'=>$temps,
            'adresse'=>$myData

           );

           //redirection vers la route resultat_suite_a_la_saisie

           return $this->render('app/index.html.twig', ['form'=> $form->createView() ,]);;
          }
          $date = date("d-m-Y");
        
        return $this->render('app/index.html.twig', ['form'=> $form->createView() ,]);;
    }





    /** Récupération de l'adresse saisie en entrée et son envoi vers l'API d'adresses du gouvernement puis stockage
    *de la latitude et longitude dans de nouvelles variables. 
    * @author CHABOUR Lina ij00898
    * @version 1.0 
    * date 13-03-2020
    * 
    */
  /**
     * @Route("/app", name="resultat_suite_a_la_saisie")
     *  
     */
    public function resultat (Request $request)
    {

//recuperer la session 
$session = $request->getSession();
//recuperer l'adresse saisie 

 $adresse = $session->get('adresse');

$date = $session->get('date');
$heure = $session->get('heure');


//Initialisation d'une session curl

 $recuperer = curl_init();

//Récupération de l'adresse et ajout de + à la place des espaces afin de l'intégrer au lien de l'api 

$adresse= preg_replace( "# #", "+", $adresse);


//Connexion à l'API, Vérification à l'aide de la  certification

curl_setopt($recuperer, CURLOPT_URL, "https://api-adresse.data.gouv.fr/search/?q=$adresse&limit=1&autocomplete=0");
curl_setopt($recuperer, CURLOPT_CAINFO, 'certif\certif.cer');
curl_setopt ($recuperer, CURLOPT_RETURNTRANSFER, true);

$donnee=curl_exec($recuperer);
  if( $donnee === false)
  {
  echo 'Erreur Curl : ' . curl_error($recuperer );
  }
    else
        {
         
          $parsee = json_decode($donnee);
        
          //Recupération de la longitude et de la latitude de l'adresse saisie

          $latitude  = $parsee->{'features'}[0]->{'geometry'}->{'coordinates'}[1];
    
          $longitude = $parsee->{'features'}[0]->{'geometry'}->{'coordinates'}[0];

        
    }
    return $this->render('app/index.html.twig', );

}
}