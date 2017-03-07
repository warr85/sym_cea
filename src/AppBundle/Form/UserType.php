<?php
/**
 * Created by Netbeans.
 * User: Wilmer Ramones
 * Date: 29/06/16
 * Time: 09:07 AM
 * Modificado: 07/07/2016
 */

namespace AppBundle\Form;


use Symfony\Component\Form\Deprecated\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Validator\Constraints\Date;
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

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fecha_ingreso', BirthdayType::class, array(
                 'widget' => 'choice',
                'label' => 'Fecha de Ingreso UBV',
                'years' => range(2003, date("Y")),
                'placeholder' => array(
                    'year' => 'Año', 'month' => 'Mes', 'day' => 'Día',
                ),
                'constraints' => array(
                    new NotBlank(),
                    new Date()
                )
            ))
            ->add('trabajo', FileType::class, array(
                'label' => 'Digital Constancia Trabajo',
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
            ->add('pregrado', FileType::class, array(
                'label' => 'Digital Título de Pregrado',
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
            
            ->add('postgrado', FileType::class, array(
                'label' => 'Digital Título de Postgrado',
                'required' => false, 
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
                
                
            ->add('lineas_investigacion', EntityType::class, array(
            'label'         => false,
            'constraints' => array(
                new NotBlank(),
            ),
            'placeholder' => 'Seleccione Área y Línea de Investigación',
            'class' => 'AppBundle:LineasInvestigacion',

            'choice_label' => 'getNombre',
            'group_by'      => 'getIdAreaInvestigacion'
            ))

            ->add('titulo_trabajo', TextType::class, array(
                'label' => 'Título del Trabajo de Investigación',
                'constraints' => array(
                    new NotBlank(),
                )
            ))
                

            ->add('oposicion', CheckboxType::class, array(
                'label'         => '¿Tiene Concurso de Oposición?',
                'required' => false,
                'mapped'    => false,
            ))

            ->add('escala', EntityType::class, array(
                'label'         => false,
                'placeholder' => 'Seleccione escala a la que concursó',
                'required' => false,
                'attr' => array(
                    'class' =>  'esc_oposicion'
                ),
                'class' => 'AppBundle:Escalafones',
                'choice_label' => 'getNombre',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.id', 'ASC');
                },
            ))
            ->add('fecha_oposicion', BirthdayType::class, array(
                'label' => 'Fecha Concurso de Oposición',
                'label_attr'    => array( 'class' => 'esc_oposicion'),
                'required' => false,
                'attr' => array(
                    'class' =>  'esc_oposicion'
                ),
                'placeholder' => array(
                    'year' => 'Año', 'month' => 'Mes', 'day' => 'Día',
                ),
                'validation_groups' => 'Oposicion',
                'constraints' => array(
                    new Date(),
                ),
                'years' => range(2003, date("Y"))
            ))
            ->add('documento_oposicion', FileType::class, array(
                'label' => 'Digital Documento Oposición',
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
                ),
                'years' => range(2003, date("Y"))
            ))
            
            ->add('documento_asistente', FileType::class, array(
                'label' => 'Digital Documento Asistente',
                'label_attr'    => array( 'class' => 'esc_asistente'),
                'required' => false,
                'attr' => array(     
                	'style' => 'display:none;',               
                    'class' =>  'esc_asistente'
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
                ),
                'years' => range(2003, date("Y"))
            ))

            ->add('documento_agregado', FileType::class, array(
                'label' => 'Digital Documento agregado',
                'label_attr'    => array( 'class' => 'esc_agregado'),
                'required' => false,
                'attr' => array(
                    'style' => 'display:none;',
                    'class' =>  'esc_agregado'
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

            ->add('ascenso3', CheckboxType::class, array(
                'label'    => '¿Otro Ascenso?',
                'label_attr'    => array( 'class' => 'esc_agregado'),
                'required' => false,
                'attr' => array(
                    'class' =>  'esc_agregado'
                )
            ))


            //Asociado
            ->add('fecha_ascenso_asociado', BirthdayType::class, array(
                'label' => 'fecha ascenso ASOCIADO',
                'label_attr'    => array( 'class' => 'esc_asociado'),
                'required' => false,
                'attr' => array(
                    'class' =>  'esc_asociado'
                ),
                'years' => range(2003, date("Y"))
            ))

            ->add('documento_asociado', FileType::class, array(
                'label' => 'Digital Documento asociado',
                'label_attr'    => array( 'class' => 'esc_asociado'),
                'required' => false,
                'attr' => array(
                    'style' => 'display:none;',
                    'class' =>  'esc_asociado'
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

            ->add('ascenso4', CheckboxType::class, array(
                'label'    => '¿Otro Ascenso?',
                'label_attr'    => array( 'class' => 'esc_asociado'),
                'required' => false,
                'attr' => array(
                    'class' =>  'esc_asociado'
                )
            ))


            //Titular
            ->add('fecha_ascenso_titular', BirthdayType::class, array(
                'label' => 'fecha ascenso TITULAR',
                'label_attr'    => array( 'class' => 'esc_titular'),
                'required' => false,
                'attr' => array(
                    'class' =>  'esc_titular'
                ),
                'years' => range(2003, date("Y"))
            ))

            ->add('documento_titular', FileType::class, array(
                'label' => 'Digital Documento titular',
                'label_attr'    => array( 'class' => 'esc_titular'),
                'required' => false,
                'attr' => array(
                    'style' => 'display:none;',
                    'class' =>  'esc_titular'
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
                      'label' => 'Formalizar Adscripción ante el CEA',
                      'attr'  => array(
                          'class' => 'btn btn-success btn-block',
                          'data-loading-text' => "<i class='fa fa-circle-o-notch fa-spin'></i> Procesando Solicitud..."
                      )
                      ))


        ;





    }


    


}
