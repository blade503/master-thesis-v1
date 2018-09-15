<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function HomeAction(Request $request)
    {
        for($i=102; $i<=202; $i++) {
            $ch = curl_init('http://localhost:8888/master-thesis-V1/client/web/graphql/delete-customer/'.$i);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 'GET');
            $content = curl_exec($ch);
            if ($content) {
                $info = curl_getinfo($ch);
                curl_close($ch);
            }
        }
        return new Response(
            'go checker le fichier graphqlGetDump.txt',
            Response::HTTP_OK,
            array('content-type' => 'text/html')
        );
    }
}
