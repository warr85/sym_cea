<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class PlanificacionSeccionShowType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //que solo salga la seccion que estamos planificando
        $this->seccion = $options['seccion'];
        //que solo salgan los temas que no han sido planificados de esa seccion
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
                'multiple'      => false,
                'expanded'      => false,
                'disabled'      => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                    ->orderBy('u.orden', 'ASC')                    
                    ->where('u.id not in (:query)') //que las uc conicidan con la malla del estado academico                                        
                    ->andWhere('u.idUnidadCurricularVolumen = ?1 ')
                    ->setParameters(array(
                        'query' => $this->planes,
                        1 => $this->seccion->getOfertaAcademica()->getIdMallaCurricularUc()->getIdUnidadCurricularVolumen()->getId()                       
                     ));                   
                 ;},
                
            ))            
            ->add('seccion', EntityType::class, array(
                'class'         => 'AppBundle:Seccion',
                'disabled'      => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')                            
                            ->where('u.id = ?1') //que las uc conicidan con la malla del estado academico                            
                    ->setParameters(array(
                        1 => $this->seccion->getId(),                                               
                     ));                   
                 ;},
             ))
            ->add('objetivoEspecifico', CollectionType::class, array(
                    'entry_type' => PlanificacionSeccionEspecificoType::class,
                    'allow_add'    => false,
                    'label'         => false,
                    'disabled'      => true,
             ))
                         
            ->add('contenido', CollectionType::class, array(
                    'entry_type' => PlanificacionSeccionContenidoType::class,
                    'allow_add'    => true,
                    'label'         => false,
                    'disabled'      => true,
             ))
                         
            ->add('estrategia', CollectionType::class, array(
                    'entry_type' => PlanificacionSeccionEstrategiaType::class,
                    'allow_add'    => true,
                    'label'         => false,
                    'disabled'      => true,
             ))
                         
             ->add('evaluacion', CollectionType::class, array(
                    'entry_type' => PlanificacionSeccionEvaluacionType::class,
                    'allow_add'    => true,
                    'label'         => false,
                    'disabled'      => true,
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
