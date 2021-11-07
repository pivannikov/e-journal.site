<?php

namespace App\Controller;

use App\Entity\Group;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GroupController extends AbstractController
{
    public function index(): Response
    {
        $groups = $this->getDoctrine()
            ->getRepository(Group::class)
            ->findAll();

        if (!$groups) {
            throw $this->createNotFoundException(
                'No groups found'
            );
        }
        return $this->render('group/index.html.twig', ['groups' => $groups]);
    }

    public function show(int $id): Response
    {
        $group = $this->getDoctrine()
            ->getRepository(Group::class)
            ->find($id);

        if (!$group) {
            throw $this->createNotFoundException(
                'No group found for id '.$id
            );
        }
        return $this->render('group/show.html.twig', ['group' => $group]);
    }

    public function addGroup(Request $request): Response
    {
        $group = new Group();

        $form = $this->createFormBuilder($group)
            ->add('number', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Add group'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $group = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($group);
            $entityManager->flush();

            return $this->redirectToRoute('all_groups');
        }

        return $this->renderForm('group/add.html.twig', [
            'form' => $form,
        ]);
    }
}
