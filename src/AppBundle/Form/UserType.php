<?php
/**
 * Created by PhpStorm.
 * User: ubv-cipee
 * Date: 29/06/16
 * Time: 09:07 AM
 */

namespace AppBundle\Form;



use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           /* ->add('fecha_ingreso', BirthdayType::class, array(
                'label' => 'Fecha de Ingreso UBV',                
            ))*/
            ->add('trabajo', FileType::class, array('label' => 'Digital Constancia Trabajo'))
            ->add('pregrado', FileType::class, array('label' => 'Digital Título de Pregrado'))
            
            ->add('postgrado', FileType::class, array('label' => 'Digital Título de Postgrado','required' => false))
            /*->add('oposicion', CheckboxType::class, array(
                'label'         => '¿Tiene Concurso de Oposición?',
                'required' => false,
            ))*/
            ->add('escala', EntityType::class, array(
                'label'         => false,
                'placeholder' => 'Seleccione escala a la que concurso',
                'required' => false,
                /*'attr' => array(
                    'class' =>  'esc_oposicion'
                ),*/
                'class' => 'AppBundle:Escalafones',
                'choice_label' => 'getNombre',
            ))
            ->add('fecha_oposicion', BirthdayType::class, array(
                'label' => 'fecha Concurso',
                //'label_attr'    => array( 'class' => 'esc_oposicion'),
                'required' => false,
               /* 'attr' => array(
                    'class' =>  'esc_oposicion'
                )*/
            ))
            /*->add('documento_oposicion', FileType::class, array(
                'label' => 'Digital Documento Oposición',
                'label_attr'    => array( 'class' => 'esc_oposicion'),
                'required' => false,
                'attr' => array(
                    'style' => 'display:none;',
                    'class' =>  'esc_oposicion'
                )
            ))
            ->add('area_investigacion', EntityType::class, array(
                'label'         => false,
                'attr' => array(
                    'class' =>  'esc_oposicion'
                ),
                'placeholder' => 'Seleccione Area de Investigacion',
                'required' => false,
                'class' => 'AppBundle:AreasInvestigacion',
                'choice_label' => 'getNombre',
            ))
            ->add('ascenso', CheckboxType::class, array(
                'label'    => '¿Ha tenido Ascenso luego del Concurso?',
                'label_attr'    => array( 'class' => 'esc_oposicion'),
                'required' => false,
                'attr' => array(
                    'class' =>  'esc_oposicion'
                )
            ))
            //Ascensos:
            //Asistente
            ->add('fecha_ascenso_asistente', BirthdayType::class, array(
                'label' => 'fecha ascenso ASISTENTE',
                'required' => false,
                'label_attr'    => array( 'class' => 'esc_asistente'),
                'attr' => array(
                    'class' =>  'esc_asistente'
                )
            ))
            
            ->add('documento_asistente', FileType::class, array(
                'label' => 'Digital Documento Asistente',
                'label_attr'    => array( 'class' => 'esc_asistente'),
                'required' => false,
                'attr' => array(     
                	'style' => 'display:none;',               
                    'class' =>  'esc_asistente'
                )
            ))
            
            ->add('ascenso2', CheckboxType::class, array(
                'label'    => '¿otro Ascenso?',
                'label_attr'    => array( 'class' => 'esc_asistente'),
                'required' => false,
                'attr' => array(
                    'class' =>  'esc_asistente'
                )
            ))
            
            //Agregado
             ->add('fecha_ascenso_agregado', BirthdayType::class, array(
                'label' => 'fecha ascenso AGREGADO',
                'label_attr'    => array( 'class' => 'esc_agregado'),
                'required' => false,
                'attr' => array(
                    'class' =>  'esc_agregado'
                )
            ))
            
            ->add('documento_agregado', FileType::class, array(
                'label' => 'Digital Documento agregado',
                'label_attr'    => array( 'class' => 'esc_agregado'),
                'required' => false,
                'attr' => array(     
                	'style' => 'display:none;',               
                    'class' =>  'esc_agregado'
                )
            ))
            
            ->add('ascenso3', CheckboxType::class, array(
                'label'    => '¿Otro Ascenso?',
                'label_attr'    => array( 'class' => 'esc_agregado'),
                'required' => false,
                'attr' => array(
                    'class' =>  'esc_agregado'
                )
            ))*/
            
		  ->add('send', SubmitType::class, array('label' => 'Enviar Solicitud'));


        ;


    }
    
    


}
