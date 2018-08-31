<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/toto", name="totoPage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/restGetCustomers", name="restGetCustomers")
     */
    public function restGetAction(Request $request)
    {
        $ch = curl_init('http://localhost:8888/master-thesis/web/app_dev.php/rest/customers');
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
     * @Route("/graphqlGetCustomers", name="restGetCustomers")
     */
    public function graphqlGetAction(Request $request)
    {
        $data = array(
            'operationName' => 'getCustomers',
            'query'=> 'query getCustomers { Customers{ id lastName firstName email city country socialSecurityNumber mobile salary createdAt }}'
        );

        $ch = curl_init('http://localhost:8888/master-thesis/web/app_dev.php/graphql');
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
