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
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ReconocimientoConcursoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                
            ->add('reconocimiento', FileType::class, array(
                'label' => 'Digital Aprobación de Escala',
               'constraints' => array(
                   new NotBlank(),
                   new File(array(
                       'maxSize'    => '1024K',
                       'mimeTypes' => [
                           'application/pdf',
                           'application/x-pdf',
                           'image/png',
                           'image/jpg',
                           'image/jpeg'
                        ],
                       'mimeTypesMessage' => 'Sólo se permiten extensiones png, jpeg y pdf'
                   ))
               )
           ))
           ->add('titulo_trabajo', TextType::class, array(
                'label' => 'Título del Trabajo de Investigación',
               
                'required' => true,
               
            ))
            ->add('lineas_investigacion', EntityType::class, array(
                'label'         => false,               
                'placeholder' => 'Seleccione Área y Línea de Investigación',
                'required' => false,
                'class' => 'AppBundle:LineasInvestigacion',

                'choice_label' => 'getNombre',
                'group_by'      => 'getIdAreaInvestigacion'
            ))
            ->add('send', SubmitType::class, array(
                  'label' => 'Enviar reconocimiento de Escala',
                  'attr'  => array('class' => 'btn btn-success btn-block')
            ))

        ;


    }
    
    
   
    
    


}
