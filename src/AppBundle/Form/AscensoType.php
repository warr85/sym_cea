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
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

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
                
             ->add('tipoTrabajoInvestigacion', ChoiceType::class, array(
                    'placeholder' => 'Seleccione el Tipo de Trabajo de Investigación',
                    'choices'  => array(                        
                        'Tesis (Trabajo de 4to nivel)' => true,
                        'Trabajo de Investigacion' => false,
                    ),
                    // *this line is important*
                    'choices_as_values' => true,
                ))
                
             
            ->add('tesisUbv', CheckboxType::class, array(
                'label'         => '¿La tesis fue realizada FUERA de la UBV?',
                'label_attr'    => array( 'class' => 'esc_tesis', 'style' => 'display:none;'),
                'required' => false,
                'attr' => array(
                    'style' => 'display:none;',
                    'class' =>  'esc_tesis'
                )
            ))
                
                
                
            ->add('titulo_trabajo', TextType::class, array(
                'label' => 'Título del Trabajo de Ascenso',                
                'required' => true,               
            ))
                
                
           ->add('aprobacion', FileType::class, array(
                'label' => 'Acta de Aprobación de la Tesis',
                'label_attr'    => array( 'class' => 'esc_tesis', 'style' => 'display:none;'),
                'required' => false,
                'attr' => array(
                    'style' => 'display:none;',
                    'class' =>  'esc_tesis'
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
                
                
            
                
          ->add('tutores_ascenso', EntityType::class, array(
                'placeholder' => 'Añadir Posibles Jurados...',   
                'class' => 'AppBundle:TutoresAscenso',
                'required' => false,
                'label' => 'Asigne Posibles Jurados',
                'label_attr'    => array( 'class' => 'esc_investigacion'),
                'multiple'  => true, 
                'group_by'  => 'institucion',
                
                /*'attr'  => array(
                    'disabled' => 'true',                    
                )*/
            ))
                
                
           ->add('curriculo', FileType::class, array(
                'label' => 'Digital de la síntesis curricular de los jurados',
                'label_attr'    => array( 'class' => 'esc_investigacion', 'style' => 'display:none;'),
                'required' => false,
                'attr' => array(                    
                    'style' => 'display:none;',
                    'class' =>  'esc_investigacion'
                ),
                'constraints' => array(
                   new File(array(
                       'maxSize'    => '1024K',
                       'mimeTypes' => [
                           'application/pdf',
                           'application/x-pdf',                           
                        ],
                       'mimeTypesMessage' => 'Sólo se permiten extensiones pdf'
                   )) 
                )
            ))
                
   
            ->add('pertinencia', FileType::class, array(
                'label' => 'Informe de Pertinencia',
                'label_attr'    => array( 'class' => 'esc_pertinencia'),
                'required' => false,
                'attr' => array(
                    'style' => 'display:none;',
                    'class' =>  'esc_pertinencia'
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
                
                
            ->add('nombreNucleo', TextType::class, array(
                'label' => 'Nombre del Núcleo al cual pertenece',
               
                'required' => true,
               
            ))

            

            
            ->add('send', SubmitType::class, array(
                'label' => 'Crear Solicitud de Ascenso',
                'attr'  => array('class' => 'btn btn-success btn-block')
                ))


        ;


    }
    
    


}
