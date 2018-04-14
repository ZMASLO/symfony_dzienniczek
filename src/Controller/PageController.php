<?php
/**
 * Created by PhpStorm.
 * User: zmaslo
 * Date: 13.04.18
 * Time: 11:48
 */

namespace App\Controller;

use App\Entity\AddUser;
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
     * @Route("/student/{student}")
     */
    public function show($student){
       return $this->render('student.html.twig', [
           'title' => $student
       ]);
    }

    /**
     * @Route("/add_student", name="add_student")
     */
    public function add_user(Request $request){
        $adduser = new AddUser();
        $form = $this->createFormBuilder($adduser)
            ->add('name', TextType::class, ['label' => 'Imie ucznia', 'empty_data' => 'Jan'])
            ->add('secondname', TextType::class, ['label' => 'Nazwisko ucznia', 'empty_data' => 'Kowalski'])
            ->add('save', SubmitType::class, array('label' => 'Dodaj ucznia'))
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $form = $form->getData();
            return $this->redirectToRoute('homepage');
        }
        return $this->render('add_student.html.twig', [
            'form' => $form->createView()
        ]);
    }
}