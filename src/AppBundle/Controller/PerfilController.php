<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserPerfilType;
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

        if(isset($file)) {// Existe el archivo enviado
            $routeDirectory = '../web/img/photos';

            $fileName = $currentUser->getUserName(). '.' . $file->guessExtension();
            $path = $fileName;
            preg_match('/^.*(png|jpg|jpeg)$/i', $file->guessExtension(), $validExt, PREG_OFFSET_CAPTURE);
            if($validExt){ // El archivo tiene la extensión correcta

                if($file->getSize()>=2000000)// El archivo se ha pasado de 2MB
                    $error = "Imagen demasiado grande (Max 2MB)";
                else if(!$file->move($routeDirectory, $fileName))// Se ha movido correctamente
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
                $msg = 'Imagen modificada';
                $type = 'success';
            }else{
                $msg = $error;
                $type = 'error';
            }

            $request->getSession()
                ->getFlashBag()
                ->add($type, $msg);

        }

        $form = $this->createForm(UserPerfilType::class,$user);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRequest = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($userRequest);
            $entityManager->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Usuario modificado')
            ;

            return $this->redirectToRoute('perfil', Array("id" => $currentUser->getId()));

        }

        return $this->render('commons/perfil.html.twig', array(
            'user_perfil' => $user,
            'current_rol' => $currentRol,
            'form' => $form->createView()
        ));
    }
}