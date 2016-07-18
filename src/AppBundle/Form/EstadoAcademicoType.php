<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EstadoAcademicoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            /*->add('fecha', 'date')
            ->add('observacion')
            ->add('idDocenteServicio')
            ->add('idRolInstitucion')*/
            ->add('idOfertaMallaCurricular', EntityType::class, array(
                'placeholder' => 'Seleccione Malla a crear Estado Academico ...',
                'class' => 'AppBundle:OfertaMallaCurricular',  
                'label' => false
            ))
            ->add('send', SubmitType::class, array(
                'label' => 'Enviar Solicitud',
                'attr'  => array('class' => 'btn btn-success')
            ))
           // ->add('idGradoAcademico')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\EstadoAcademico'
        ));
    }
}
