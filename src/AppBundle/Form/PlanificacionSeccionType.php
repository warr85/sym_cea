<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class PlanificacionSeccionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->seccion = $options['seccion'];
        $this->planificacion = $options['planificacion'];        
        if (!$this->planificacion){
            $this->planes[] = 0;            
        }else{
            foreach ($this->planificacion as $p){
                $this->planes[] = $p->getIdtemaUc()->getId();
            }
            
        }
        //var_dump($this->seccion); exit;
        $builder
            
            ->add('idtemaUc', EntityType::class, array(
                'class'         => 'AppBundle:UnidadCurricularVolumenTema',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                    ->orderBy('u.orden', 'ASC')                    
                    ->where('u.id not in (:query)') //que las uc conicidan con la malla del estado academico                                        
                    ->andWhere('u.idUnidadCurricularVolumen = ?1')
                    ->setParameters(array(
                        'query' => $this->planes,
                        1 => $this->seccion->getOfertaAcademica()->getIdMallaCurricularUc()->getIdUnidadCurricularVolumen()->getId()                       
                     ));                   
                 ;},
                
            ))            
            ->add('seccion', EntityType::class, array(
                'class'         => 'AppBundle:Seccion',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')                            
                            ->where('u.id = ?1') //que las uc conicidan con la malla del estado academico                            
                    ->setParameters(array(
                        1 => $this->seccion->getId(),                                               
                     ));                   
                 ;},
             ))
            ->add('contenido', CollectionType::class, array(
                    'entry_type' => PlanificacionSeccionContenidoType::class,
                    'allow_add'    => true,
                    'label'         => false
             ))
            
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'    => 'AppBundle\Entity\PlanificacionSeccion',
            'seccion'       => null,
            'planificacion' => null,
        ));
    }
}
