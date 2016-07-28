<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PlanificacionSeccionEstrategiaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tecnicas',  EntityType::class, array(
                'class' => 'AppBundle:TecnicasPlanificacion',
                'multiple' => TRUE,
                'expanded' => TRUE,                                                                
            ))
            ->add('recursos',  EntityType::class, array(
                'class' => 'AppBundle:RecursosPlanificacion',
                'multiple' => TRUE,
                'expanded' => TRUE,                                                                
            ))           
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\PlanificacionSeccionEstrategia'
        ));
    }
}
