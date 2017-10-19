<?php
/**
 * Created by PhpStorm.
 * User: ubv-cipee
 * Date: 01/07/16
 * Time: 07:52 AM
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Constraints\Regex;


class SolicitarType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombres', TextType::class, array(
                'attr' => array('placeholder' => 'Primer Nombre...'),
                'label' => 'Primer Nombre',
                'constraints' => array(
                    new NotBlank(),
                    new Regex(array(
                        'pattern'   => '/^([a-zA-ZáéíóúÁÉÍÓÚñÑ\']{2,30}\S+)$/',
                        'match'     => true,
                        'message'   => 'no debe contener espacios ni números y tener mínino tres caracteres.'
                    ))
                )
            ))
            ->add('apellidos', TextType::class, array(
                'attr' => array('placeholder' => 'Primer Apellido...'),
                'label' => 'Primer Apellido',
                'constraints' => array(
                    new NotBlank(),
                    new Regex(array(
                        'pattern'   => '/^([a-zA-ZáéíóúÁÉÍÓÚñÑ\']{2,30}\S+)$/',
                        'match'     => true,
                        'message'   => 'no debe contener espacios ni números y tener mínino tres caracteres.'
                    ))
                )
            ))
            ->add('cedula', NumberType::class, array(
                'attr' => array('placeholder' => 'Cédula o Pasaporte...'),
                'constraints' => array(
                    new NotBlank(),
                    new Length(array('min' => 7)),
                    new Length(array('max' => 10)),
                ),
                'label' => 'Cédula'
            ))
                
            ->add('pfg', EntityType::class, array(
                'placeholder' => 'Seleccione PFG al cual está adscrito',
                'class' => 'AppBundle:AreaInstitucion',
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('pfg')
                            ->where('pfg.idTipoArea = 1');
                },
                'constraints' => array(
                    new NotBlank()
                ),
                'choice_label' => 'getNombre',
            ))
                
            ->add('correo', EmailType::class, array(
                'attr' => array('placeholder' => 'Dirección de Correo...'),
                'constraints' => array(
                    new NotBlank(),
                    new Email()
                )
            ))

            ->add('eje', EntityType::class, array(
                'placeholder' => 'Seleccione el Eje al Cual está Adscrito',
                'class' => 'AppBundle:Eje',
                'choice_label' => 'getNombre',
                'constraints' => array(
                    new NotBlank()
                )
            ))

            ->add('eje_parroquia', EntityType::class, array(
                'placeholder' => 'Seleccione Estado del Eje',
                'label' => 'Estado',
                'class' => 'AppBundle:EjeParroquia',
                'choice_label' => 'estado',
                'constraints' => array(
                    new NotBlank()
                )
            ))

            ->add('send', SubmitType::class, array(
                'label' => 'Enviar Solicitud',
                'attr'  => array(
                    'class' => 'btn btn-success cargando',
                    'data-loading-text' => "<i class='fa fa-circle-o-notch fa-spin'></i> Enviando Solicitud..."
                )
             ));


    }





//    /**
//     * @param OptionsResolver $resolver
//     */
//    public function configureOptions(OptionsResolver $resolver)
//    {
//        $resolver->setDefaults(array(
//            'data_class' => 'AppBundle\Entity\Usuarios'
//        ));
//    }
}