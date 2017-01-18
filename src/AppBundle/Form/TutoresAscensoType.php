<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class TutoresAscensoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idDocumentoIdentidad', EntityType::class, array(                
                'label' => 'Tipo Documento',
                'placeholder' => 'Seleccione...',
                'class' => 'AppBundle:DocumentoIdentidad',                                
            ))
            ->add('cedulaPasaporte', TextType::class, array(                
                'label'         => 'Cédula/Pasaporte',                
                'attr'  => array(
                    'placeholder' => 'Cédula Pasaporte ...',
                    'class' => 'col-lg-4 form-control',                     
                )
            ))
                
            ->add('buscarTutor', ButtonType::class, array(                
                'label' => 'Añadir',
                'attr'  => array('class' => 'btn btn-primary btn-block'),
            ))
                
            
                
                
            ->add('nombres', TextType::class, array(                
                'label'         => 'Nombres Tutor',                
                'label_attr' => array('class' => 'hidden oculto'),
                'attr'  => array(   
                    'placeholder' => 'Nombres del Tutor...',
                    'class' => 'col-lg-6 form-control hidden oculto',                     
                )
            ))
                
            ->add('apellidos', TextType::class, array(                
                'label'         => 'Apellidos Tutor',
                'label_attr' => array('class' => 'hidden oculto'),                
                'attr'  => array(
                    'placeholder' => 'apellidos del tutor...',
                    'class' => 'col-lg-3 form-control hidden oculto',                     
                )
            ))
                
            ->add('institucion', TextType::class, array(                
                'label'         => 'Institución',
                'label_attr' => array('class' => 'hidden oculto'),                
                'attr'  => array(
                    'placeholder' => 'UBV, LUZ, UNEFM,',
                    'class' => 'col-lg-3 form-control hidden oculto',                     
                )
            ))
                
            ->add('idEstado', EntityType::class, array(                
                'label' => 'Estado',
                'label_attr' => array('class' => 'hidden oculto'),
                'placeholder' => 'Estado donde Labora...',
                'class' => 'AppBundle:Estado',                
                'attr'  => array(                    
                    'class' => 'col-lg-3 form-control hidden oculto',                   
                )
            ))
                
            ->add('idEscala', EntityType::class, array(                
                'label' => 'Escalafón',
                'label_attr' => array('class' => 'hidden oculto'),                
                'placeholder' => 'Escalafón actual...',
                'class' => 'AppBundle:Escalafones',                
                'attr'  => array(                    
                    'class' => 'col-lg-3 form-control hidden oculto',                    
                )
            ))
            ->add('correoElectronico', EmailType::class, array(
                'label'         => 'Correo E.', 
                'label_attr' => array('class' => 'hidden oculto'),                
                'attr'  => array(
                    'placeholder' => 'Dirección de Correo Tutor ...',
                    'class' => 'col-lg-3 form-control hidden oculto',               
                )
            ))
            ->add('registrar', SubmitType::class, array(
                'label' => 'Registrar',
                'attr'  => array('class' => 'btn btn-success hidden oculto'),
            ))
            /*->add('nombres')
            ->add('apellidos')
            ->add('institucion')            
            ->add('idEscala')*/
            ->add('ascenso')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\TutoresAscenso'
        ));
    }
}
