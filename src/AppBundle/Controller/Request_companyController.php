<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Company;
use AppBundle\Entity\Project;
use AppBundle\Entity\Request_company;
use AppBundle\Form\ProjectType;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Exception\NotNullConstraintViolationException;
use Doctrine\ORM\EntityManager;
use PHPExcel_IOFactory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Filesystem\Filesystem;
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
        $file = $request->files->get('file_uploaded');

        $error = "";

        if(isset($btn_submit)) {
            if(isset($file)) {
                $file = $request->files->get('file_uploaded');
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $original_name = $file->getClientOriginalName();
                $file->move($this->container->getParameter('file_directory'), $fileName);
                $path = $this->container->getParameter('file_directory') . '/' . $fileName;

                $file_entity = new UploadedFile ($path, $original_name);

                $objReader = PHPExcel_IOFactory::createReader('Excel2007');
                $objReader->setLoadSheetsOnly('FCT'); // Especificamos la hoja de cálculo
                $objPHPExcel = $objReader->canRead($file_entity);

                if ($objPHPExcel) { //El archivo es válido
                    $objPHPExcel = $objReader->load($file_entity);

                    $worksheet = $objPHPExcel->getActiveSheet();
                    $cells = $worksheet->toArray();

                    $entityManager = $this->getDoctrine()->getManager();
                    $emCov = $entityManager->getRepository('AppBundle:Convocatory');
                    $currentConvocatory = $this->getUser()->getCurrentConvocatory();
                    $currentYear = $emCov->find($currentConvocatory)->getSchoolYear();

                    for ($i = 1; $i < $worksheet->getHighestRow(); $i++) {
                        if ($cells[$i][0] == null) {
                            break;
                        }
                        try{
                            $request_company = new Request_company();
                            $request_company->setNameCompany($cells[$i][0]);
                            $request_company->setCif($cells[$i][1]);
                            $request_company->setHeadquartersOfWork($cells[$i][2]);
                            $request_company->setHeadquartersPrincipal($cells[$i][3]);
                            $request_company->setContactPerson($cells[$i][4]);
                            $request_company->setEmail($cells[$i][5]);
                            $request_company->setPhone($cells[$i][6]);
                            $request_company->setManager($cells[$i][7]);
                            $request_company->setNifManager($cells[$i][8]);
                            $request_company->setTutor($cells[$i][9]);
                            $request_company->setNifTutor($cells[$i][10]);
                            $request_company->setNumberOfDaw(intval($cells[$i][11]));
                            $request_company->setNumberOfAsir(intval($cells[$i][12]));
                            $request_company->setTypeOfWorkDay($cells[$i][13]);
                            $request_company->setTasksToBeDone($cells[$i][14]);
                            $request_company->setObservations($cells[$i][15]);
                            $request_company->setSchoolYear($currentYear);

                            $entityManager->persist($request_company);
                            $entityManager->flush();
                        }catch (DBALException $e){
                            $error = 'Ha sucedido un problema en la fila ('. $i .') del documento.';
                            break;
                        }


                    }

                    if($error == "") {
                        $request->getSession()
                            ->getFlashBag()
                            ->add('success', 'Solicitudes creadas');
                    }

                } else {//Si el archivo no es válido
                    $error = "El archivo no es válido";
                }
                unlink($path);
            }else{
                $error = "No has subido ningún archivo";
            }
        }
        return $this->render('user/fct/request_company/new.html.twig', array(
            'title' => "Subir solicitudes de empresa",
            'error' => $error,
        ));
    }

    /**
     * @Route("user/fct/request_company/{id}/delete", name="user_fct_delete_request_company")
     */
    public function deleteProjectAction(Request $request,Request_company $request_company)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($request_company);
        $em->flush();

        $request->getSession()
            ->getFlashBag()
            ->add('success', 'Solicitud borrada')
        ;
        return $this->redirectToRoute('user_fct', ['_fragment' => 'solemp']);
    }

    /**
     * @Route("user/fct/request_company/{id}/show", name="user_fct_show_request_company", methods="GET")
     */
    public function showProject(Request_company $request_company)
    {
        $em = $this->getDoctrine();

        return $this->render('user/fct/request_company/show.html.twig', array(
            'request_company' => $request_company,
        ));
    }

    /**
     * @Route("/user/fct/requestCompany/{id}/new", name="user_fct_new_com_req")
     */
    public function newCompanyAction(Request $request, Request_company $request_company)
    {
        $newCompany = new Company();
        $newCompany->setName($request_company->getNameCompany());
        $newCompany->setCif($request_company->getCif());
        $newCompany->setPhone($request_company->getPhone());
        $newCompany->setEmail($request_company->getEmail());

        $em = $this->getDoctrine()->getManager();
        $em->persist($newCompany);
        $em->flush();

        $request->getSession()
            ->getFlashBag()
            ->add('success', 'Empresa creada')
        ;
        return $this->redirectToRoute('user_fct', ['_fragment' => 'emp']);
    }
}