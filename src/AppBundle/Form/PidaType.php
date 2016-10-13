<?php
/**
 * Created by Netbeans.
 * User: Wilmer Ramones
 * Date: 29/06/16
 * Time: 09:07 AM
 * Modificado: 07/07/2016
 */

namespace AppBundle\Form;

use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class PidaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            

            ->add('plan_historico_nacional_estrategico', EntityType::class, array(
                'label'         => false,
                'attr' => array(
                    'class' =>  'select2'
                ),
                
                'placeholder' => 'Seleccione Plan Nacional que se relaciona con su Actividad PIDA',
                'required' => false,
                'class' => 'AppBundle:PlanHistoricoNacionalEstrategico',
                'choice_label' => 'getNombre',
                'group_by'      => 'getIdPlanHistoricoNacional'

            ))

           

            
		 


        ;


    }
    
    


}
