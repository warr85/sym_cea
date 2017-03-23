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


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PidaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                
                ->add('id_plan_historico_nacional_estrategico', EntityType::class, array(
                    'label'         => 'Objetivos Históricos',
                    'attr' => array(
                                'class' =>  'select2'
                                ),                
                    'placeholder' => 'Seleccione Plan Nacional que se relaciona con su Actividad PIDA',
                    'required' => true,
                    'class' => 'AppBundle:PlanHistoricoNacionalEstrategico',
                    'choice_label' => 'getNombre',
                    'group_by'      => 'getIdPlanHistoricoNacional'
                ))

                ->add('id_actividad_docente', EntityType::class, array(
                    'label'         => 'Actividad Docente',
                    'attr' => array(
                                'class' =>  'select2'
                             ),
                
                    'placeholder' => '¿Bajo cúal actividad docente está enmarcado dicho objetivo?',
                    'required' => true,
                    'class' => 'AppBundle:ActividadDocente',
                    'choice_label' => 'getNombre'                

                ))
                
                ->add('objetivo_especifico', TextType::class, array(
                    'label' => 'Tarea'
                ))
                
                ->add('fecha_inicio')
                
                ->add('fecha_final')


        ;


    }
    
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\AdscripcionPida'
        ));
    }
    
    


}
