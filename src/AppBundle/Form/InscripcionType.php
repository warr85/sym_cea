<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class InscripcionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->estado_academico = $options['inscripcion'];
        if (count($this->estado_academico->getHasInscripcion()) == 0){
            $tray = 1;
            $tram = 1; 
        }        
        echo $tray;
        $builder
            /*->add('idRolInstitucion')
            ->add('idOfertaAcademica')
            ->add('idEstatus')*/            
            ->add('idOfertaAcademica', EntityType::class, array(
                'class' => 'AppBundle:OfertaAcademica',
                'expanded'  => true,
                'multiple'  => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                    ->orderBy('u.idMallaCurricularUc', 'ASC')
                    ->innerJoin('u.idMallaCurricularUc', 'm', 'WITH', 'm.idTrayectoTramoModalidadTipoUc = ?2')                    
                    ->where('u.idOfertaMallaCurricular = ?1') //que las uc conicidan con la malla del estado academico                                        
                    ->setParameters(array(
                        1 => $this->estado_academico->getIdOfertaMallaCurricular(),
                        2 => 1,
                     ));                   
                 ;},
                 'group_by'      => 'idSeccion'
            ))
            
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\EstadoAcademico',
            'inscripcion' => null,
        ));
    }
}
