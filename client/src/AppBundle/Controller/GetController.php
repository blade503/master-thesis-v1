<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GetController extends Controller
{
    /**
     * @Route("/rest/get-customers", name="rest-get-customers")
     */
    public function restGetsAction(Request $request)
    {
        $ch = curl_init('http://localhost:8888/thesis/rest/web/app_dev.php/customers');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,'GET');
        $content = curl_exec($ch);
        if($content)
        {
            $info = curl_getinfo($ch);
            return $this->render('default/restGet.html.twig', [
                'totalTime' => $info['total_time'],
                'url' => $info['url'],
                'content' => $content
            ]);
        }

        return null;
    }

    /**
     * @Route("/graphql/get-customers", name="graphql-get-customers")
     */
    public function graphqlGetsAction(Request $request)
    {
        $data = array(
            'operationName' => 'getCustomers',
            'query'=> 'query getCustomers { Customers{ id lastName firstName email city country socialSecurityNumber mobile salary createdAt }}'
        );

        $ch = curl_init('http://localhost:8888/thesis/graphql/web/app_dev.php/graphql');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 'GET');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $content = curl_exec($ch);
        if($content)
        {
            $info = curl_getinfo($ch);
            return $this->render('default/restGet.html.twig', [
                'totalTime' => $info['total_time'],
                'url' => $info['url'],
                'content' => $content
            ]);
        }

        return null;
    }

    /**
     * @Route("/rest/get-customer/{id}", name="rest-get-customer")
     */
    public function restGetAction(Request $request)
    {
        $ch = curl_init('http://localhost:8888/thesis/rest/web/app_dev.php/customers/'.$request->get('id'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,'GET');
        $content = curl_exec($ch);
        if($content)
        {
            $info = curl_getinfo($ch);
            curl_close($ch);
            return $this->render('default/restGet.html.twig', [
                'totalTime' => $info['total_time'],
                'url' => $info['url'],
                'content' => $content
            ]);
        }

        return null;
    }

    /**
     * @Route("/graphql/get-customer/{id}", name="graphql-get-customer")
     */
    public function graphqlGetAction(Request $request)
    {
        $data = array(
            'operationName' => 'getCustomer',
            'query'=> 'query getCustomer { Customer(id:'.$request->get('id').'){ id lastName firstName email city country socialSecurityNumber mobile salary createdAt }}'
        );

        $ch = curl_init('http://localhost:8888/thesis/graphql/web/app_dev.php/graphql');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 'GET');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $content = curl_exec($ch);
        if($content)
        {
            $info = curl_getinfo($ch);
            curl_close($ch);
            return $this->render('default/restGet.html.twig', [
                'totalTime' => $info['total_time'],
                'url' => $info['url'],
                'content' => $content
            ]);
        }

        return null;
    }
}
