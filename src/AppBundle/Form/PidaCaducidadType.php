<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\NotBlank;

class PidaCaducidadType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fechaInicio',DateType::class, array(
        'widget' => 'choice',
        'label' => 'Pida inicia desde: ',
        'label_attr' => array('class' => 'form-group'),
        'years' => range(date("Y")-2, date("Y")),
        'placeholder' => array(
            'year' => 'Año', 'month' => 'Mes', 'day' => 'Día',
        ),
        'constraints' => array(
            new NotBlank(),
            new Date()
        )
    ))
            ->add('fechaFinal',DateType::class, array(
                'widget' => 'choice',
                'label' => 'Pida Finaliza el: ',
                'label_attr' => array('class' => 'form-group'),
                'years' => range(date("Y")-2, date("Y")+4),
                'placeholder' => array(
                    'year' => 'Año', 'month' => 'Mes', 'day' => 'Día',
                ),
                'constraints' => array(
                    new NotBlank(),
                    new Date()
                )
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\PidaCaducidad'
        ));
    }
}
