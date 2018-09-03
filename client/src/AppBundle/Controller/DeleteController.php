<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends Controller
{
    /**
     * @Route("/rest/delete-customer/{id}", name="rest_delete_customer")
     */
    public function restDeleteAction(Request $request)
    {

        $ch = curl_init($this->container->getParameter('base_url').'rest/web/app_dev.php/customers/'.$request->get('id'));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        $content = curl_exec($ch);
        if($content)
        {
            $info = curl_getinfo($ch);
            curl_close($ch);
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
     * @Route("/graphql/delete-customer/{id}", name="graphql_delete_customer")
     */
    public function graphqlDeleteAction(Request $request)
    {
        $data = array(
            'operationName' => 'DeleteCustomer',
            'query'=> 'mutation DeleteCustomer { DeleteCustomer(id: '.$request->get('id').')}'
        );

        $ch = curl_init($this->container->getParameter('base_url').'graphql/web/app_dev.php/graphql');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $content = curl_exec($ch);
        if($content)
        {
            $info = curl_getinfo($ch);
            curl_close($ch);
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
}
