<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Project;
use AppBundle\Form\ProjectType;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class Request_companyController extends Controller
{
    /**
     * @Route("/user/fct/requestCompany/new", name="user_fct_reqcom")
     * @Method({"GET", "POST"})
     */
    public function newRequestCompanyAction(Request $request)
    {
        $btn_submit = $request->get('btn_submit');
        if(isset($btn_submit)) {
            $file = $request->files->get ( 'file_uploaded' );
            $fileName = md5 ( uniqid () ) . '.' . $file->guessExtension ();
            $original_name = $file->getClientOriginalName ();
            $file->move ( $this->container->getParameter ( 'file_directory' ), $fileName );
            $path = $this->container->getParameter ( 'file_directory' ).'/'.$fileName;

            $file_entity = new UploadedFile ($path, $original_name);

            $fileExcel = $this->get('phpexcel')->createPHPExcelObject($file_entity);
            dump($fileExcel);
            die();
        }

        /*
        $file = $request->files->get ( 'my_file' );
        $fileName = md5 ( uniqid () ) . '.' . $file->guessExtension ();
        $original_name = $file->getClientOriginalName ();
        $file->move ( $this->container->getParameter ( 'file_directory' ), $fileName );
        $file_entity = new UploadedFile ();
        $file_entity->setFileName ( $fileName );
        $file_entity->setActualName ( $original_name );
        $file_entity->setCreated ( new \DateTime () );
*/


        return $this->render('user/fct/request_company/new.html.twig', array(
            'title' => "Subir solicitud empresa",
        ));
    }

}