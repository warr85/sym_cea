<?php
/**
 * Created by Netbeans.
 * User: Wilmer Ramones
 * Date: 29/06/16
 * Time: 09:07 AM
 * Modificado: 07/07/2016
 */

namespace AppBundle\Form;



use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class AddTutorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
           
                
          ->add('tutores_ascenso', EntityType::class, array(
                'placeholder' => 'Añadir Posibles Jurados...',   
                'class' => 'AppBundle:TutoresAscenso',
                'required' => false,
                'label' => 'Asignar Jurados',                
                'multiple'  => true, 
                'group_by'  => 'institucion',               
            ))
   
           


        ;


    }
    
    


}
