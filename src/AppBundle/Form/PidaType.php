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

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PidaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                
                ->add('id_plan_historico_nacional_estrategico', EntityType::class, array(
                    'label'         => false,
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
                    'label'         => false,
                    'attr' => array(
                                'class' =>  'select2'
                             ),
                
                    'placeholder' => '¿Bajo cúal actividad docente está enmarcado dicho objetivo?',
                    'required' => true,
                    'class' => 'AppBundle:ActividadDocente',
                    'choice_label' => 'getNombre'                

                ))
                
                ->add('objetivo_especifico')
                
                ->add('fecha_inicio')
                
                ->add('fecha_final')
                
                ->add('send', SubmitType::class, array(
                      'label' => 'Enviar Actividad PIDA',
                      'attr'  => array('class' => 'btn btn-success btn-block')
                ))

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
