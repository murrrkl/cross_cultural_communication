<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MyController extends AbstractController
{
    /**
     * @Route("/my", name="my", methods={"GET"})
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

        $a = $request->request->get('a');
        /*file_put_contents('test.txt', $a."\n", 8);*/
        $fp = fopen("test.txt", "w");
        fwrite($fp, $a);
        fclose($fp);
        echo $a;
        file_put_contents('test.txt', $a."\n", 8);
        return $this->render('my/index.html.twig', [
            'text' => $a,
        ]);
    }
}
