<?php
/**
 * Created by PhpStorm.
 * User: miguel
 * Date: 12/05/18
 * Time: 11:00
 */

namespace AppBundle\Controller;


use AppBundle\Services\StudentsHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/panel/student")
 */
class PanelStudentController extends Controller
{
    /**
     * @Route("/view", name="panel_students")
     */
    public function viewAction(Request $request)
    {
        /** @var StudentsHelper $cashFlowHelper */
        $studentsHelper = $this->get('app.studentsHelper');

        $students = $studentsHelper->getAllStudents();

        return $this->render('panel/student/view.html.twig', array(
            'students' => $students
        ));
    }
}