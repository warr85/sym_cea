<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;


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
                'label' => false,
                'placeholder' => 'Tipo Documento...',
                'class' => 'AppBundle:DocumentoIdentidad',                
                'attr'  => array(                    
                    'class' => 'col-lg-4',                     
                )
            ))
            ->add('cedulaPasaporte', TextType::class, array(                
                'label'         => false,                
                'attr'  => array(
                    'placeholder' => 'introudzca la cédula',
                    'class' => 'col-lg-4 form-control',                     
                )
            ))
                
            ->add('buscarTutor', ButtonType::class, array(                
                'label' => 'Añadir',
                'attr'  => array('class' => 'btn btn-primary col-lg-4'),
            ))
                
            ->add('etiqueta', TextType::class, array(                
                'label'         => false,
                'data'     => "Tutor no Encontrado, por favor Registre al nuevo Tutor",
                'attr'  => array(
                    'placeholder' => 'Nombres del tutor...',
                    'class' => 'alert alert-warning col-lg-12 hidden oculto',                     
                )
            ))
                
                
            ->add('nombres', TextType::class, array(                
                'label'         => 'nombres',                
                'label_attr' => array('class' => 'hidden oculto'),
                'attr'  => array(                    
                    'class' => 'col-lg-6 form-control hidden oculto',                     
                )
            ))
                
                ->add('apellidos', TextType::class, array(                
                'label'         => false,                
                'attr'  => array(
                    'placeholder' => 'apellidos del tutor...',
                    'class' => 'col-lg-3 form-control hidden oculto',                     
                )
            ))
            /*->add('correoElectronico', EmailType::class, array(
                'label'         => false,                
                'attr'  => array(
                    'placeholder' => 'introudzca correo Electrónico del tutor',
                    'class' => 'col-lg-6 form-group',                     
                )
            ))
            ->add('nombres')
            ->add('apellidos')
            ->add('institucion')            
            ->add('idEscala')*/
            //->add('ascenso')
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
