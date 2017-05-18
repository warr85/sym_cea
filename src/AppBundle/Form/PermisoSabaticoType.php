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
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class PermisoSabaticoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('fechaInicio',DateType::class, array(
                'widget' => 'choice',
                'label' => 'Permisio inicia desde',
                'label_attr' => array('class' => 'form-group'),
                'years' => range(date("Y"), date("Y")+2),
                'placeholder' => array(
                    'year' => 'Año', 'month' => 'Mes', 'day' => 'Día',
                ),
                'constraints' => array(
                    new NotBlank(),
                    new Date()
                )
            ))
                
            ->add('motivo', FileType::class, array(
                'label' => 'Digital Carta Exposición de Motivos',
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
            ->add('send', SubmitType::class, array(
                  'label' => 'Enviar motivo',
                  'attr'  => array(
                      'class' => 'btn btn-success btn-block',
                      'data-loading-text' => "<i class='fa fa-circle-o-notch fa-spin'></i> Procesando Solicitud..."
                  )
            ))

        ;


    }
    
    
   
    
    


}
