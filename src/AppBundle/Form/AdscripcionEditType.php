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
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;

class AdscripcionEditType extends AbstractType
{

    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // grab the user, do a quick sanity check that one exists
        $user = $this->tokenStorage->getToken()->getUser();
        if (!$user) {
            throw new \LogicException(
                'The FriendMessageFormType cannot be used without an authenticated user!'
            );
        }

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($user) {

            $form = $event->getForm();
            $existe = false;
            foreach ($user->getIdRolInstitucion()->getDocumentosVerificados() as $documentos){
                if($documentos->getIdServicio()->getIdServicioCe()->getId() == 2 && $documentos->getIdEstatus()->getId() == 3){
                    $existe = true;
                    $form->add($documentos->getIdTipoDocumentos()->getIdentificador(), FileType::class, array(
                        'label' => $documentos->getIdTipoDocumentos()->getNombre(),
                        'constraints' => array(
                            new NotBlank(),
                            new File(array(
                                'maxSize'    => '1024K',
                                'mimeTypes' => [
                                    'application/pdf',
                                    'application/x-pdf',
                                    'image/png',
                                    'image/jpg',
                                    'image/jpeg'
                                ],
                                'mimeTypesMessage' => 'Sólo se permiten extensiones png, jpeg y pdf'
                            ))
                        )
                    ));


                }

            }
            if($existe){
                $form->add('send', SubmitType::class, array(
                    'label' => 'Reenviar Documentos Rechazados',
                    'attr'  => array(
                        'class' => 'btn btn-success btn-block',
                        'data-loading-text' => "<i class='fa fa-circle-o-notch fa-spin'></i> Procesando Solicitud..."
                    )
                ));
            }


        });

    }


    


}
