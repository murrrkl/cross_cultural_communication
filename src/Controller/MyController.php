<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MyController extends AbstractController
{
    /**
     * @Route("/my", name="my")
     */
    public function index(): Response
    {
        return $this->render('my/index.html.twig', [
            'controller_name' => 'MyController',
        ]);
    }

    /**
     * @Route("/my", name="my_search", methods={"POST"})
     */

    public function search(Request $request)
    {

        $a = $request->request->getText('a');
        $fp = fopen("test.txt", "w");
        fwrite($fp, $a);
        fclose($fp);
    }
}
