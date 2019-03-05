<?php

namespace App\Controller;

use App\Entity\Entries;
use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EntryController extends AbstractController
{
//    /**
//     * @Route("/entry", name="entry")
//     */
//    public function index()
//    {
//        return $this->render('entry/index.html.twig', [
//            'controller_name' => 'EntryController',
//        ]);
//    }

       public function entryView($taskId)
       {
           $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
           $taskRepository = $this->getDoctrine()->getRepository(Task::class);
           $entriesRepository = $this->getDoctrine()->getRepository(Entries::class);
           $task = $taskRepository->findOneBy(['id' => $taskId]);
           $entries = $entriesRepository->findBy(['projectId' => $taskId]);
           $datas = array('task' => $task, 'entries' => $entries);

           return $this->render('task/newEntry.html.twig', ['data' => $datas]);
       }

       public function newEntry(Request $request)
       {
           $data = $request->request->all();
           $entityManager = $this->getDoctrine()->getManager();
           $currentDate = new \DateTime();

           $entry = new Entries();
           $entry->setProjectId($data['projectId']);
           $entry->setEntry(\DateTime::createFromFormat('H:i:s', $data['entry']));
           $entry->setDateCreated(\DateTime::createFromFormat('Y/m/d',$currentDate->format('Y/m/d')));

           $entityManager->persist($entry);
           $entityManager->flush();

           return new Response('Woohoo Success');

       }
}
