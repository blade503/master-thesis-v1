<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends Controller
{
    /**
     * @Route("/rest/POSTCustomers", name="restPOSTCustomers")
     */
    public function restPostAction(Request $request)
    {
        $ch = curl_init('http://localhost:8888/thesis/rest/web/app_dev.php/customers');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        if(curl_exec($ch))
        {
            $info = curl_getinfo($ch);
            $content = curl_exec($ch);
            return $this->render('default/restGet.html.twig', [
                'totalTime' => $info['total_time'],
                'url' => $info['url'],
                'content' => $content
            ]);
        }

        return null;
    }

    /**
     * @Route("/graphql/POSTCustomers", name="graphqlPOSTCustomers")
     */
    public function graphqlPostAction(Request $request)
    {
        $data = array(
            'operationName' => 'getCustomers',
            'query'=> 'query getCustomers { Customers{ id lastName firstName email city country socialSecurityNumber mobile salary createdAt }}'
        );

        $ch = curl_init('http://localhost:8888/thesis/graphql/web/app_dev.php/graphql');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        if(curl_exec($ch))
        {
            $info = curl_getinfo($ch);
            $content = curl_exec($ch);
            return $this->render('default/restGet.html.twig', [
                'totalTime' => $info['total_time'],
                'url' => $info['url'],
                'content' => $content
            ]);
        }

        return null;
    }
}
