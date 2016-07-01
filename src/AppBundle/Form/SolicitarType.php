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
                'attr' => array('placeholder' => 'Nombres...'),
                'constraints' => array(
                    new NotBlank(),
                    new Length(array('min' => 3)),
                )
            ))
            ->add('apellidos', TextType::class, array(
                'attr' => array('placeholder' => 'Apellidos...'),
                'constraints' => array(
                    new NotBlank(),
                    new Length(array('min' => 3)),
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
            ))
            ->add('send', SubmitType::class, array('label' => 'Enviar Solicitud'));
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