<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetController extends Controller
{
    /**
     * @Route("/rest/get-customers", name="rest-get-customers")
     */
    public function restGetsAction(Request $request)
    {
        $ch = curl_init($this->container->getParameter('base_url').'rest/web/app_dev.php/customers');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $content = curl_exec($ch);
        if($content)
        {
            $info = curl_getinfo($ch);
            file_put_contents('../../restGetsDump.txt', $info['request_size'].", ".$info['total_time']."\n", FILE_APPEND);
            return $this->render('default/restGet.html.twig', [
                'totalTime' => $info['total_time'],
                'headerSize' => $info['header_size'],
                'requestSize' => $info['request_size'],
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

        $ch = curl_init($this->container->getParameter('base_url').'graphql/web/app_dev.php/graphql');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $content = curl_exec($ch);
        if($content)
        {
            $info = curl_getinfo($ch);
            return $this->render('default/graphQLGetsDump.html.twig', [
                'totalTime' => $info['total_time'],
                'headerSize' => $info['header_size'],
                'requestSize' => $info['request_size'],
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
        $ch = curl_init($this->container->getParameter('base_url').'rest/web/app_dev.php/customers/'.$request->get('id'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,'GET');
        $content = curl_exec($ch);
        if($content)
        {
            $info = curl_getinfo($ch);
            curl_close($ch);
            file_put_contents('../../restGetRequestSize.txt', $info['request_size']."\n", FILE_APPEND);
            file_put_contents('../../restGetReponseTime.txt', $info['total_time']."\n", FILE_APPEND);
            return new Response(
                'go checker le fichier restGetRequestSize.txt',
                Response::HTTP_OK,
                array('content-type' => 'text/html')
            );
            /*return $this->render('default/restGet.html.twig', [
                'totalTime' => $info['total_time'],
                'headerSize' => $info['header_size'],
                'requestSize' => $info['request_size'],
                'url' => $info['url'],
                'content' => $content
            ]);*/
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

        $ch = curl_init($this->container->getParameter('base_url').'graphql/web/app_dev.php/graphql');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 'GET');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $content = curl_exec($ch);
        if($content)
        {
            $info = curl_getinfo($ch);
            curl_close($ch);
            file_put_contents('../../graphqlGetRequestSize.txt', $info['request_size']."\n", FILE_APPEND);
            file_put_contents('../../graphqlGetReponseTime.txt', $info['total_time']."\n", FILE_APPEND);
            return new Response(
                'go checker le fichier graphqlGetDump.txt',
                Response::HTTP_OK,
                array('content-type' => 'text/html')
            );
        }

        return null;
    }
}
