<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Company;
use AppBundle\Entity\Project;
use AppBundle\Entity\Request_company;
use AppBundle\Form\ProjectType;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Exception\NotNullConstraintViolationException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManager;
use PHPExcel_IOFactory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
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
        $current_convocatory = $this->getUser()->getCurrentConvocatory();
        if(!$this->get('app.functionsHelper')->isConvocatoryValid($current_convocatory)) {
            $request->getSession()
                ->getFlashBag()
                ->add('error', 'Convocatoria antigua (Solo lectura)')
            ;
            return $this->redirectToRoute('user_fct');
        }

        $btn_submit = $request->get('btn_submit');
        $file = $request->files->get('file_uploaded');

        $error = "";

        if(isset($btn_submit)) {
            if(isset($file)) {
                $routeDirectory = '../web/uploads/assets';
                $file = $request->files->get('file_uploaded');
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $original_name = $file->getClientOriginalName();
                $file->move($routeDirectory, $fileName);
                $path = $routeDirectory . '/' . $fileName;

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
                        $fileSystem = new Filesystem();
                        $fileSystem->remove($path);
                        return $this->redirectToRoute('user_fct', ['_fragment' => 'solemp']);
                    }

                } else {//Si el archivo no es válido
                    $error = "El archivo no es válido";
                }
                $fileSystem = new Filesystem();
                $fileSystem->remove($path);
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
     * @Route("/user/fct/requestCompany/massiveSelect", name="user_fct_massive_request_company")
     */
    public function massiveAction(Request $request)
    {
        $current_convocatory = $this->getUser()->getCurrentConvocatory();
        if(!$this->get('app.functionsHelper')->isConvocatoryValid($current_convocatory)) {
            $request->getSession()
                ->getFlashBag()
                ->add('error', 'Convocatoria antigua (Solo lectura)')
            ;
            return $this->redirectToRoute('user_fct');
        }

        $type = 'success';
        $msg = "";
        $numerrors = 0;

        $btnSave = $request->get('savemassive');
        $btnDelete = $request->get('deletemassive');

        if(isset($btnSave)){ // Pulsado botón guardar
            $solicitudes = $request->get('solc');

            if(!$solicitudes){
                $type = 'error';
                $msg = 'Solicitudes no seleccionadas';
            }else{
                $em = $this->getDoctrine()->getManager();
                foreach ($solicitudes as $key => $value){
                    $request_company = $this->get('app.requestCompany')->getRequest($key);
                    $newCompany = new Company();
                    $newCompany->setName($request_company->getNameCompany());
                    $newCompany->setCif($request_company->getCif());
                    $newCompany->setPhone($request_company->getPhone());
                    $newCompany->setEmail($request_company->getEmail());

                    try{
                        $validator = $this->get('validator');
                        $errorCode = $validator->validate($newCompany)->getIterator();
                        if(!isset($errorCode[0]) || $errorCode[0]->getCode() != '23bd9dbf-6b9b-41cd-a99e-4844bcf3077f'){
                            $em->persist($newCompany);
                            $em->flush();

                            $em->remove($request_company);
                            $em->flush();

                        }else{
                            $msg = 'Ya existe '.$newCompany->getName();
                            $request->getSession()
                                ->getFlashBag()
                                ->add('error', $msg)
                            ;
                            $numerrors++;
                        }

                    }catch (DBALException $e){
                        $numerrors++;
                        $msg = "Error inesperado";
                        $request->getSession()
                            ->getFlashBag()
                            ->add('error', $msg)
                        ;
                        break;
                    }

                }
                if($numerrors > 0 && $numerrors == count($solicitudes)){ // No se ha creado ninguna empresa
                    $type = 'error';
                    $msg = 'No se ha creado ninguna empresa';
                }else{
                    $type = 'success';
                    $msg = 'Se ha creado '. (count($solicitudes) - $numerrors) .' de '. count($solicitudes);
                }
            }

        }else if(isset($btnDelete)){ // Pulsado botón borrar
            $solicitudes = $request->get('solc');

            if(!$solicitudes){
                $type = 'error';
                $msg = 'Solicitudes no seleccionadas';
            }else{
                foreach ($solicitudes as $key => $value){
                    $request_company = $this->get('app.requestCompany')->getRequest($key);

                    try{
                        $em = $this->getDoctrine()->getManager();
                        $em->remove($request_company);
                        $em->flush();
                        $msg = 'Solicitudes borradas';
                    }catch (DBALException $e){
                        $numerrors++;
                        switch ($e->getPrevious()->errorInfo[1]){
                            case 1451:
                                $msg = "La solicitud se está usando";
                                break;
                            default:
                                $msg = "Error inesperado";
                                break;
                        }

                        $request->getSession()
                            ->getFlashBag()
                            ->add('error', $msg)
                        ;
                        break;
                    }

                }
                if($numerrors > 0){
                    $type = 'error';
                    $msg = 'Ha ocurrido '.$numerrors.' error/es';
                }
            }

        }else{
            $type = 'error';
            $msg = 'No has pulsado ningún botón';
        }

        $request->getSession()
            ->getFlashBag()
            ->add($type, $msg)
        ;

        return $this->redirectToRoute('user_fct', ['_fragment' => 'solemp']);
    }


}