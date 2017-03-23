<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PidaTareaEspecificoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pidaTareaEspecifico', \Symfony\Component\Form\Extension\Core\Type\TextType::class, array(
                'label' => 'Tarea: '
            ))
            ->add('idPidaPlazo', EntityType::class, array(
                'class' => 'AppBundle:PidaPlazo',
                'label' => 'Plazo de la Tarea: ',
                'label_attr' => array('class' => 'radio-inline'),



                'choice_label' => 'nombre',

                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                'expanded' => true,
            ))


            ->add('idPidaEstatus', EntityType::class, array(
                'class' => 'AppBundle:PidaEstatus',
                'label' => 'Estado Actual de la tarea:',
                'label_attr' => array('class' => 'radio-inline'),
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.id', 'ASC');
                },

                // use the User.username property as the visible option string
                'choice_label' => 'nombre',

                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                'expanded' => true,
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\PidaTareaEspecifico'
        ));
    }
}
