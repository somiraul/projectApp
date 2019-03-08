<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\TestImageUploadResized;
use App\Entity\User;
use App\Service\ImageManagementService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class WebsiteController extends AbstractController
{
    private $passwordEncoder;
    private $imageManager;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, ImageManagementService $imageManager)
    {
         $this->passwordEncoder = $passwordEncoder;
         $this->imageManager = $imageManager;
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
        if ($request->getMethod() == 'POST' && !empty($request->request))
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

    public function imageCropper()
    {
        list($usec, $sec) = explode(" ", microtime());
        $time = (float)$sec;
        $sessionTime = date('H:i:s', $time);
//        dd(date('H:i:s', $time));
        return $this->render('test_crud_entity/cropperTest.html.twig', ['sessionTime' => $sessionTime]);
    }

    public function croppedImageUploader(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $file = new TestImageUploadResized();
        $image = $request->files->get('croppedImage');
        $fileName = $this->generateUniqueFileName().'.'.$image->guessExtension();
        $imageSize = $this->generateImageSizes($image, $ratio);
        $image->move($this->getParameter('profilePictures'), $fileName);
        $file->setImageName($fileName);
        $entityManager->persist($file);
        $entityManager->flush();

        return new Response('TestResponse');
    }

    public function generateImageSizes(UploadedFile $file, $ratio) {

        if($ratio == '16:9'){
            $sizes =   array (
                "small"  => array(500,280),
                "medium" => array(750,420),
                "large"  => array(1500,840)
            );


            foreach ($sizes as $key => list($w, $h)) {
                $this->imageManager->resize_image($file, $w, $h, $key);
            }
        } elseif($ratio == '4:3'){
            $sizes =   array (
                "small"  => array(300,225),
                "medium" => array(700,525),
                "large"  => array(1400,1050)
            );

            foreach ($sizes as $key => list($w, $h)) {
                $this->imageManager->resize_image($file, $w, $h, $key);
            }
        } else {
            list($width, $height) = getimagesize($file);

            $this->imageManager->resize_image($file, $width, $height, 'large');
            $this->imageManager->resize_image($file, $width/2, $height/2, 'medium');
            $this->imageManager->resize_image($file, $width/3, $height/3, 'small');

        }
    }

}
