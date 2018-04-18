<?php
/**
 * Created by PhpStorm.
 * User: zmaslo
 * Date: 13.04.18
 * Time: 11:48
 */

namespace App\Controller;

use App\Entity\AddUser;
use App\Entity\Presence;
use App\Entity\Student;
use function PHPSTORM_META\type;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\DateTime;

class PageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepage()
    {
        $student=$this->getDoctrine()->getRepository(Student::class)->findAll();
        $presence=$this->getDoctrine()->getRepository(Presence::class)->findBy([
            'date' => new \DateTime()
        ]);
        return $this->render('homepage.html.twig',[
            'students' => $student,
            'presence' => $presence
        ]);
    }

    /**
     * @Route("/student/{id}")
     */
    public function show($id){
        $student = $this->getDoctrine()->getRepository(Student::class)->find($id);
        $presence=$this->getDoctrine()->getRepository(Presence::class)->findBy(
            ['student' => $id]
        );
        if(!$student){
            throw $this->createNotFoundException(
                'Brak ucznia o id: '.$id
            );
        }
       return $this->render('student.html.twig', [
           'name' => $student->getName(),
           'secondname' => $student->getSecondname(),
           'presence' => $presence
       ]);
    }

    /**
     * @Route("/list_students", name="list_students")
     */
    public function list_students(){
        $students = $this->getDoctrine()->getRepository(Student::class)->findAll();
        return $this->render('list_students.html.twig',[
           'students' => $students
        ]);
    }
    /**
     * @Route("/new_student", name="new_student")
     */
    public function new_user(Request $request){
        $student = new Student();
        $form = $this->createFormBuilder($student)
            ->add('name', TextType::class, ['label'=>'Imie'])
            ->add('secondname', TextType::class, ['label'=>'Nazwisko'])
            ->add('save',SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $form = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($student);
            $entityManager->flush();
            return $this->redirectToRoute('list_students');
        }
        return $this->render('new_student.html.twig',[
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/delete_student/{id}")
     */
    public function delete_student($id){
        $entityManager = $this->getDoctrine()->getManager();
        $student = $entityManager->getRepository(Student::class)->find($id);
        $presence = $entityManager->getRepository(Presence::class)->findBy([
            'student' => $id
        ]);
        $entityManager->remove($presence);
        $entityManager->remove($student);
        $entityManager->flush();
        return $this->redirectToRoute('list_students');

    }
    /**
     * @Route("/presence/{id}/{status}")
     */
    public function presence($id, $status){
        if($status!='O' && $status!='N' && $status!='S'){
            return $this->redirectToRoute('homepage');
        }
        $entityManager = $this->getDoctrine()->getManager();
        $student = $this->getDoctrine()->getRepository(Student::class)->find($id);
        $presence = $this->getDoctrine()->getRepository(Presence::class)->findOneBy([
            'student' => $id,
            'date' => new \DateTime()
        ]);
        if(!$presence){
            $presence = new Presence();
            $presence->setStudent($student);
            $presence->setDate(new \DateTime());
            $presence->setStatus($status);
            $entityManager->persist($presence);
            $entityManager->flush();
            return $this->redirectToRoute('homepage');
        }
        $presence->setStatus($status);
        $entityManager->flush();
        return $this->redirectToRoute('homepage');
    }
}