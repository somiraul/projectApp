<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class WebsiteController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
         $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/website", name="website")
     */
    public function index()
    {
        return $this->render('website/register.html.twig');
    }

    public function register(Request $request)
    {
        $data = $request->request->all();
        $entityManager = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setFirstName($data['firstName']);
        $user->setLastName($data['lastName']);
        $user->setEmail($data['email']);
        $user->setPassword($this->passwordEncoder->encodePassword($user, $data['password']));
        $entityManager->persist($user);
        $entityManager->flush();

        return new Response('Successfully Registered');

    }

    public function profile()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $userId = $this->getUser()->getId();
        $repository = $this->getDoctrine()->getRepository(Task::class);
        $tasks = $repository->findBy(['user_id' => $userId]);

        return $this->render('website/profile.html.twig',  array('tasks' => $tasks));
    }

    public function UserProfile()
    {
        return $this->render('website/userProfile.html.twig');
    }
}
