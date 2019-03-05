<?php

namespace App\Controller;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
//    /**
//     * @Route("/task", name="task")
//     */
//    public function index()
//    {
//        return $this->render('task/index.html.twig', [
//            'controller_name' => 'TaskController',
//        ]);
//    }

    public function addProjectView()
    {
        $userId = $this->getUser()->getId();
        return $this->render('task/addNewProject.html.twig', ['userId' => $userId]);
    }

    /*
     * @Route("/addProject", name="addProject")
     */
    public function addProject(Request $request)
    {
        $data = $request->request->all();

        $entityManager = $this->getDoctrine()->getManager();

        $task = new Task();
        $task->setProjectName($data['projectName']);
        $task->setStartDate(\DateTime::createFromFormat('d/m/Y', $data['startDate']));
        $task->setEndDate(\DateTime::createFromFormat('d/m/Y', $data['endDate']));
        $task->setUserId($data['userId']);

        $entityManager->persist($task);
        $entityManager->flush();

        return new Response('Added Successfully');

    }
}
