<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class OfertaAcademicaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder            
            ->add('idMallaCurricularUc', EntityType::class, array(
                'label'         => false,                
                'placeholder' => 'Seleccione Unidad Curricular',
                'class' => 'AppBundle:MallaCurricularUc',
                'choice_label' => 'idUnidadCurricularVolumen.idUnidadCurricular',
                'group_by' => function($val, $key, $index) {

                        return "Trayecto: " . $val->getIdTrayectoTramoModalidadTipoUc()->getIdTrayecto() 
                                . " Tramo: " . $val->getIdTrayectoTramoModalidadTipoUc()->getIdTramo() . ". "
                                . $val->getIdTrayectoTramoModalidadTipoUc()->getIdModalidad()
                                . "( " . $val->getIdTrayectoTramoModalidadTipoUc()->getIdTipoUc() . " )"
                        ;                    
                },
                     
            ))
            ->add('idTurno')
            ->add('idSeccion')
            ->add('aula')
            ->add('cupo')
            ->add('idRolInstitucion', EntityType::class, array(
                'class'         => 'AppBundle:RolInstitucion',
                'placeholder'   => 'Seleccione Docente a Dictar UC',
                'label'         => false
            ))
            ->add('idOfertaMallaCurricular')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\OfertaAcademica'
        ));
    }
}
