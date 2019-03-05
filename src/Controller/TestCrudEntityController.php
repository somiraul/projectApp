<?php

namespace App\Controller;

use App\Entity\TestCrudEntity;
use App\Form\TestCrudEntityType;
use App\Repository\TestCrudEntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/test/crud/entity")
 */
class TestCrudEntityController extends AbstractController
{
    /**
     * @Route("/", name="test_crud_entity_index", methods={"GET"})
     */
    public function index(TestCrudEntityRepository $testCrudEntityRepository): Response
    {
        return $this->render('test_crud_entity/index.html.twig', [
            'test_crud_entities' => $testCrudEntityRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="test_crud_entity_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $testCrudEntity = new TestCrudEntity();
        $form = $this->createForm(TestCrudEntityType::class, $testCrudEntity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($testCrudEntity);
            $entityManager->flush();

            return $this->redirectToRoute('test_crud_entity_index');
        }

        return $this->render('test_crud_entity/new.html.twig', [
            'test_crud_entity' => $testCrudEntity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="test_crud_entity_show", methods={"GET"})
     */
    public function show(TestCrudEntity $testCrudEntity): Response
    {
        return $this->render('test_crud_entity/show.html.twig', [
            'test_crud_entity' => $testCrudEntity,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="test_crud_entity_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TestCrudEntity $testCrudEntity): Response
    {
        $form = $this->createForm(TestCrudEntityType::class, $testCrudEntity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('test_crud_entity_index', [
                'id' => $testCrudEntity->getId(),
            ]);
        }

        return $this->render('test_crud_entity/edit.html.twig', [
            'test_crud_entity' => $testCrudEntity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="test_crud_entity_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TestCrudEntity $testCrudEntity): Response
    {
        if ($this->isCsrfTokenValid('delete'.$testCrudEntity->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($testCrudEntity);
            $entityManager->flush();
        }

        return $this->redirectToRoute('test_crud_entity_index');
    }
}
