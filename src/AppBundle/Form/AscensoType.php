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

class AscensoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('trabajo', FileType::class, array(
                'label' => 'Digital Constancia Trabajo Actualizada',
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
            ->add('expediente', FileType::class, array(
                'label' => 'Digital Actualización de Expediente',
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
            
            ->add('pida', FileType::class, array(
                'label' => 'Digital Socialización del PIDA',
                'required' => true, 
                'constraints' => array(
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
                
            ->add('nai', FileType::class, array(
                'label' => 'Digital Aval del NAI',
                'required' => true, 
                'constraints' => array(
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
                
                
            ->add('tutores_asignados', EntityType::class, array(
                'placeholder' => 'Añadir Tutores...',
                'class' => 'AppBundle:TutoresAscenso',  
                'label' => false
            ))
                
                
            ->add('investigacion', FileType::class, array(
                'label' => 'Digital Trabajo de investigación / Tesis',
                'required' => true, 
                'constraints' => array(
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
                
                
            ->add('tipoTrabajoInvestigacion', CheckboxType::class, array(
                'label'         => 'Si su trabajo de investigación es TESIS, responda ¿Fue realizado fuera de la UBV?',
                'required' => false,
            ))
   
            ->add('pertinencia', FileType::class, array(
                'label' => 'Informe de Pertinencia',
                'label_attr'    => array( 'class' => 'esc_oposicion'),
                'required' => false,
                'attr' => array(
                    'style' => 'display:none;',
                    'class' =>  'esc_oposicion'
                ),
                'constraints' => array(
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

            

            
		  ->add('send', SubmitType::class, array(
                      'label' => 'Crear Solicitud de Ascenso',
                      'attr'  => array('class' => 'btn btn-success btn-block')
                      ))


        ;


    }
    
    


}
