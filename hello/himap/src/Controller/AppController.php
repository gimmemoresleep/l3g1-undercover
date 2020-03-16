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


    /** Modification de la fonction index : Ajout de création de l'objet, vérification du formulaire ainsi que
     * la récupération des données saisies par l'utilisateur, envoi de l'adresse saisie vers l'api du gouvernement 
     * et sa conversion en longitude et latitude.
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
        $temps= "null";
        $date = null;
        $heure = null;
        $latitude = null;
        $longitude = null;
        $transport = null;

        //verification de la validite et la soummision du formulaire saisie
        if ($form->isSubmitted() && $form->isValid())
         {
            //recuperation de l'adresse et du rayon saisie 
            $myData = $form->get('adresse')->getData();
            $transport=$form->get('transport')->getData();
            $temps=$form->get('temps')->getData();
            $date = date("m-d-Y");
            $heure = date('h:i A', strtotime($date));
            //stockage du rayon et l'adresse saisie dans une session 
            $session = $request->getSession();
            $session->set('adresse',$myData);
            $session->set('transport',$transport);
            $session->set('temps',$temps);
            $session->set('date',$date);
            

          //Initialisation d'une session curl
          $recuperer = curl_init();
                    
          //Récupération de l'adresse et ajout de + à la place des espaces afin de l'intégrer au lien de l'api
          $adresse= preg_replace( "# #", "+",$myData);
 
 
          //Connexion à l'API, Vérification à l'aide de la  certification
          curl_setopt($recuperer, CURLOPT_URL, "https://api-adresse.data.gouv.fr/search/?q=$adresse&limit=1&autocomplete=0");
          curl_setopt($recuperer, CURLOPT_CAINFO, 'certif/certif.cer');
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
              $date = date("m-d-Y");
              $heure = date('h:i A', strtotime($date));

              $temps1 = $temps/3;
              $temps2 = 2*$temps/3;

              $polygone=curl_init();
              curl_setopt($polygone, CURLOPT_URL, "http://localhost:8080/otp/routers/graphs/isochrone?fromPlace=$latitude,$longitude&mode=$transport&date=$date&time=$heure&cutoffSec$temps1&cutoffSec=$temps2&cutoffSec=$temps");
              curl_setopt ($polygone, CURLOPT_RETURNTRANSFER, true);
              $poly =curl_exec($polygone);
              
              if($poly === false){
                echo 'Erreur Curl : ' . curl_error($recuperer );
              }
              $rec = json_decode($poly);

              $data1 = $poly->{'features'}[0]->{'geometry'}->{'coordinates'}[0][0];
              $data2 = $poly->{'features'}[1]->{'geometry'}->{'coordinates'}[0][0];

              if($poly->{'features'}[2]->{'geometry'}->{'coordinates'}[0][0] !== null){
                  $data3 = $poly->{'features'}[2]->{'geometry'}->{'coordinates'}[0][0];
              }
              

              return $this->render('app/index.html.twig', ['form'=> $form->createView() ,'longitude' =>$longitude,'latitude' => $latitude,'temps' => $temps,'transport' => $transport,'date' => $date , 'heure' =>$heure,'temps'=>$temps,]);;
          }
          
        
        return $this->render('app/index.html.twig', ['form'=> $form->createView() ,'longitude' =>$longitude,'latitude' => $latitude,'temps' => $temps,'transport' => $transport,'date' => $date , 'heure' =>$heure, 'temps'=>$temps,]);;
    }



return $this->render('app/index.html.twig', ['form'=> $form->createView() ,'longitude' =>$longitude,'latitude' => $latitude,'temps' => $temps,'transport' => $transport,'date' => $date , 'heure' =>$heure,'temps'=>$temps,]);
 
    
}
}
