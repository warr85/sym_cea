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

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ReconocimientoEscalaType extends AbstractType
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
            ->add('send', SubmitType::class, array(
                  'label' => 'Enviar reconocimiento de Escala',
                  'attr'  => array(
                      'class' => 'btn btn-success btn-block',
                      'data-loading-text' => "<i class='fa fa-circle-o-notch fa-spin'></i> Procesando Solicitud..."
                  )
            ))

        ;


    }
    
    
   
    
    


}
