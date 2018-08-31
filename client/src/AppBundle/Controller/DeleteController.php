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
        $ch = curl_init('http://localhost:8888/thesis/rest/web/app_dev.php/customers/'.$request->get('id'));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
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
     * @Route("/graphql/delete-customer/{id}", name="graphql_delete_customer")
     */
    public function graphqlDeleteAction(Request $request)
    {
        $data = array(
            'operationName' => 'DeleteCustomer',
            'query'=> 'mutation DeleteCustomer { DeleteCustomer(id: '.$request->get('id').')}'
        );

        $ch = curl_init('http://localhost:8888/thesis/graphql/web/app_dev.php/graphql');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 'POST');
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
}
