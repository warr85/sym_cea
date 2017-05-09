<?php
/**
 * Created by PhpStorm.
 * User: ubv-cipee
 * Date: 29/06/16
 * Time: 09:08 AM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\DocumentosVerificados;
use AppBundle\Entity\PidaCaducidad;
use AppBundle\Entity\PidaEstatus;
use AppBundle\Entity\PidaTareaEspecifico;
use AppBundle\Form\PidaTareaEspecificoType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Adscripcion;
use AppBundle\Entity\DocenteEscala;
use AppBundle\Entity\Memorando;
use AppBundle\Entity\DocenteServicio;
use AppBundle\Entity\AdscripcionPida;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class PermisosController extends Controller
{
    /**
     * @Route("/solicitud/permisos", name="permisos_index")
     */
    public function permisosIndexAction()
    {
        return $this->render('solicitudes/permisos_index.html.twig', array(

        ));
    }


}

    
    
