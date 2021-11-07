<?php

namespace App\Controller;

use App\Entity\Discipline;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DisciplineController extends AbstractController
{
    public function index(): Response
    {
        $disciplines = $this->getDoctrine()
            ->getRepository(Discipline::class)
            ->findAll();

        if (!$disciplines) {
            throw $this->createNotFoundException(
                'No disciplines found'
            );
        }
        return $this->render('discipline/index.html.twig', ['disciplines' => $disciplines]);
    }

    public function show(string $slug): Response
    {
        $discipline = $this->getDoctrine()
            ->getRepository(Discipline::class)
            ->findBySlug($slug);

        if (!$discipline) {
            throw $this->createNotFoundException(
                'No disciplines found for slug '.$slug
            );
        }
        return $this->render('discipline/show.html.twig', ['discipline' => $discipline]);
    }

    public function addDiscipline(Request $request): Response
    {
        $discipline = new Discipline();

        $form = $this->createFormBuilder($discipline)
            ->add('title', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Add group'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $discipline = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($discipline);
            $entityManager->flush();

            return $this->redirectToRoute('all_disciplines');
        }

        return $this->renderForm('discipline/add.html.twig', [
            'form' => $form,
        ]);
    }
}
