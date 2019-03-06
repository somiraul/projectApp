<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

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
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $userId = $this->getUser()->getId();
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $user = $userRepository->findBy(['id' => $userId]);

        return $this->render('website/userProfile.html.twig', ['user' => $user]);
    }

    public function updateUserProfile(Request $request)
    {
//        var_dump($request->files->get('_profilePicture')); die();
        $entityManager = $this->getDoctrine()->getManager();

        $userId = $this->getUser()->getId();
        $user = $entityManager->getRepository(User::class)->find($userId);

        if (!empty($request->request->all()))
        {
            if ($request->request->get('_fname'))
            {
                $user->setFirstName($request->request->get('_fname'));
            }

            if ($request->request->get('_lname'))
            {
                $user->setLastName($request->request->get('_lname'));
            }

            if ($request->request->get('_email'))
            {
                $user->setEmail($request->request->get('_email'));
            }

            if ($request->request->get('_password'))
            {
                $user->setPassword($this->passwordEncoder->encodePassword($user, $request->request->get('_password')));
            }

            if($request->files->get('_profilePicture'))
            {
                $file = $request->files->get('_profilePicture');
                $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
                $file->move($this->getParameter('profilePictures'), $fileName);

                $user->setProfilePicture($fileName);
                $entityManager->persist($user);
            }

            $entityManager->flush();

            return new Response('Updated Successfully');

        } else {

            return new Response('UserId or Data Not Found');

        }
    }

    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }


}
