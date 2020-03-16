<?php

namespace App\Form;

use App\Entity\SaisirAdresse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


/**
 * Création du Formulaire 
 * @author CHABOUR Lina ij00898
 * date 12-03-2020
 * @version 1.0
 */

class SaisieAdresseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

        //Ajout des attributs adresse, temps et transport au formulaire et spécification de leur valeur de retour


            ->add('adresse')
            ->add('temps', ChoiceType::class, array(
                'choices'=> array(
                    'Temps' => '',
                    '15min' => 900,
                    '30min' => 1800,
                    '45min' => 2700,
                    '1heure' => 3600,
                    '1heure15min' => 4500,
                    '1heure30min' => 5400,
                ),
            ))
            ->add('transport', ChoiceType::class, array(
                'choices'=> array(
                    'Moyen de Transport' => " ",
                    'Velo' => 'BICYCLE',
                    'Voiture' => 'CAR',
                    'Marche à pieds' => 'WALK',
                    'Transports en communs' => 'WALK,TRANSIT',

                ),
            ))
        ;
    }


    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SaisirAdresse::class,
        ]);
    }
}
