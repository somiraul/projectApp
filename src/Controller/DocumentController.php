<?php

namespace App\Controller;

use App\Entity\DocumentEntity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class DocumentController extends AbstractController
{
    /**
     * @Route("/document", name="document")
     */
    public function index()
    {
        return $this->render('document/index.html.twig');
    }

    public function uploadAction(Request $request)
    {
        $file = $request->files;
        $document = new DocumentEntity();

        if ($file->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            $em->persist($document);
            $em->flush();

            return $this->redirect($this->generateUrl('testNameForGeneratedUrl', ['max' => 10]));
        }

        return new Response('TestSucks');

    }

    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile())
        {
            return;
        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues

        // move takes the target directory and then the
        // target filename to move to
        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->getFile()->getClientOriginalName()
        );

        // set the path property to the filename where you've saved the file
        $this->path = $this->getFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }

}
