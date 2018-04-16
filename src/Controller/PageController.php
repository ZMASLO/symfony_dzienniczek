<?php
/**
 * Created by PhpStorm.
 * User: zmaslo
 * Date: 13.04.18
 * Time: 11:48
 */

namespace App\Controller;

use App\Entity\AddUser;
use App\Entity\Student;
use function PHPSTORM_META\type;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepage()
    {
        return new Response('hello!');
    }

    /**
     * @Route("/student/{id}")
     */
    public function show($id){
        $student = $this->getDoctrine()
            ->getRepository(Student::class)
            ->find($id);

       return $this->render('student.html.twig', [
           'name' => $student->getName(),
           'secondname' => $student->getSecondname()
       ]);
    }

    /**
     * @Route("/new_student", name="new_student")
     */
    public function new_user(Request $request){
        $student = new Student();
        $form = $this->createFormBuilder($student)
            ->add('name', TextType::class)
            ->add('secondname', TextType::class)
            ->add('save',SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $form = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($student);
            $entityManager->flush();
            return $this->redirectToRoute('homepage');
        }
        return $this->render('new_student.html.twig',[
            'form' => $form->createView()
        ]);
    }
}