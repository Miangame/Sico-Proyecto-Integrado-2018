<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Regex;

class PerfilController extends Controller
{
    /**
     * @Route("/perfil/{id}", name="perfil")
     * @Method({"GET", "POST"})
     */
    public function perfilUser(Request $request,User $user)
    {
        $currentUser = $this->getUser();

        if($currentUser->getId() != $user->getId())
            return $this->redirectToRoute('dashboard');

        if($currentUser->hasRole('ROLE_ADMIN'))
            $currentRol = "AppBundle:PanelDashboard:dashboard";
        else
            $currentRol = "AppBundle:UserDashboard:dashboard";


        $file = $request->files->get('file_uploaded');

        $error = "";

        if(isset($file)) {
            $routeDirectory = '../web/img/photos';

            $file = $request->files->get('file_uploaded');
            $fileName = $currentUser->getUserName(). '.' . $file->guessExtension();
            $path = $fileName;
            preg_match('/^.*(png|jpg|jpeg)$/i', $file->guessExtension(), $validExt, PREG_OFFSET_CAPTURE);
            if($validExt){
                if(!$file->move($routeDirectory, $fileName))
                    $error = "No se ha podido guardar la imagen";
                else{// archivo correcto
                    $user->setImg($path);
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($user);
                    $entityManager->flush();
                }
            }else{
                $error = "Imagen no válida(png/jpg/jpeg)";
            }


            if($error == "") {
                $msg = 'Perfil modificado';
                $type = 'success';
            }else{
                $msg = $error;
                $type = 'error';
            }

            $request->getSession()
                ->getFlashBag()
                ->add($type, $msg);

        }else{
            $error = "No has subido ningún archivo";
        }

        return $this->render('commons/perfil.html.twig', array(
            'user_perfil' => $currentUser,
            'current_rol' => $currentRol
        ));
    }
}