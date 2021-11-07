<?php

namespace App\Controller;

use App\Entity\Group;
use App\Entity\Student;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentController extends AbstractController
{
    public function index(): Response
    {
        $students = $this->getDoctrine()
            ->getRepository(Student::class)
            ->findAll();

        if (!$students) {
            throw $this->createNotFoundException(
                'No student found'
            );
        }

        return $this->render('student/index.html.twig', ['students' => $students]);
    }

    public function show(int $id): Response
    {
        $student = $this->getDoctrine()
            ->getRepository(Student::class)
            ->find($id);

        if (!$student) {
            throw $this->createNotFoundException(
                'No student found for id '.$id
            );
        }

        $groupNumber = $student->getStudyGroup()->getNumber();

        return $this->render('student/show.html.twig', ['student' => $student, 'group_number' => $groupNumber]);
    }

    public function addStudent(Request $request): Response
    {
        $student = new Student();
        $groups = $this->getDoctrine()
            ->getRepository(Group::class)
            ->findAll();

        $form = $this->createFormBuilder($student)
            ->add('first_name', TextType::class)
            ->add('last_name', TextType::class)
            ->add('study_group', TextType::class, [
                'required' => false,
            ])
            ->add('age', IntegerType::class)
            ->add('save', SubmitType::class, ['label' => 'Add student'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $student = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($student);
            $entityManager->flush();

            return $this->redirectToRoute('all_students');
        }

        return $this->renderForm('student/add.html.twig', [
            'form' => $form,
        ]);
    }

    public function update(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $student = $entityManager->getRepository(Student::class)->find($id);

        if (!$student) {
            throw $this->createNotFoundException(
                'No student found for id '.$id
            );
        }

        $form = $this->createFormBuilder($student)
            ->add('first_name', TextType::class)
            ->add('last_name', TextType::class)
            ->add('study_group', TextType::class, [
                'required' => false,
            ])
            ->add('age', IntegerType::class)
            ->add('save', SubmitType::class, ['label' => 'Update info'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $student = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($student);
            $entityManager->flush();

            return $this->redirectToRoute('all_students');
        }

        return $this->renderForm('student/add.html.twig', [
            'form' => $form,
        ]);

    }

    public function delete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $student = $entityManager->getRepository(Student::class)->find($id);

        if (!$student) {
            throw $this->createNotFoundException(
                'No student found for id '.$id
            );
        }

        $entityManager->remove($student);
        $entityManager->flush();

        return $this->redirectToRoute('all_students');

    }
}
