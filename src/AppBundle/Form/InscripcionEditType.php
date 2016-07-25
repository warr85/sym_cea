<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class InscripcionEditType extends AbstractType
{
    
    private $isGranted;

    public function __construct($roleFlag)
    {
      $this->isGranted = $roleFlag;
      //var_dump($this->isGranted); exit;
    }
        
     
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->oferta = $options['oferta'];
        $builder
            ->add('idSeccion', EntityType::class, array(
                'class' => 'AppBundle:Seccion',
                'query_builder' => function (EntityRepository $er){
                    return $er->createQueryBuilder('u')
                            ->where('u.ofertaAcademica = ?1')
                            ->setParameters(array(
                                1 => $this->oferta   
                            ));
                        
                },
                ));
             
        if($this->isGranted){
            $builder->add('idEstatus'); 
        }

        
                
                
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'    => 'AppBundle\Entity\Inscripcion',
            'oferta'        => null
        ));
    }
}
