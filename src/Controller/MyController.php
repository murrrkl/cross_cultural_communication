<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SituationsRepository;

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
        if ($a == '') {
            return $this->render('my/index.html.twig', [
                'emty_text' => $a,
            ]);
        }
        $a = str_replace('.','',$a);
        $fp = fopen("/www/test.txt", "w");
        fwrite($fp, $a);
        fclose($fp);
        //echo $a;
        $resulting = 1;
        $code = 0;
        $count = 0;
        $last_line = system('docker run --rm -v /www:/mnt nlpub/tomita bash /mnt/start.sh', $retval);
        /*$fd = fopen("/www/output.txt", 'r') or die("не удалось открыть файл");
        while(!feof($fd))
        {
            //str = htmlentities(fgets($fd));
            //echo str;
            //echo htmlentities(fgets($fd));
            $str = htmlentities(fgets($fd));
            $result = substr($str, strpos($str, '=') + 1, strlen($str));
            echo $result;
            //echo "new";
        }
        fclose($fd);*/
        $stack = array();
        $myFile = "/www/output.txt";
        $lines = file($myFile);//file in to an array
        if (count($lines) > 1) {
            $mySituation = $lines[1];

            for ($i = 3; $i < count($lines) - 1; $i++) {
                $str = $lines[$i];
                $result = substr($str, strpos($str, '=') + 1, strlen($str));
                array_push($stack, $result);
                //echo $result;
            }
            //echo $mySituation; //line 2
            //$result = exec('docker run --rm -v /www:/mnt nlpub/tomita bash /mnt/start.sh', $resulting,$code);
            //echo implode('<br>', $stack);
            /*foreach ($stack as &$value) {
                echo $value;
            }*/
            //Удаление первого и последнего символа
            $mySituation = substr($mySituation,1,-1);
            //Число символов
            //echo iconv_strlen($mySituation);

            //Поиск в БД нужного обосования
            $query = $this->getDoctrine()->getManager();
            $query = $query->createQueryBuilder();
            $query->select('node')
                ->from('App\Entity\Situations', 'node')
                ->where('node.number = :number')
                ->setParameter('number', $mySituation);
            $situations = $query->getQuery()->getResult();
            return $this->render('my/index.html.twig', [
                'situations' => $situations,
                'keys' => $stack,
            ]);
        } else {

            $error_search = 1;

            return $this->render('my/index.html.twig', [
                'error_search' => $error_search,
            ]);

        }

    }
}
