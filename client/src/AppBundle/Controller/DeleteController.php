<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $content = curl_exec($ch);
        if($content)
        {
            $info = curl_getinfo($ch);
            curl_close($ch);
            file_put_contents('../../restdeleteRequestSize.txt', $info['request_size']."\n", FILE_APPEND);
            file_put_contents('../../restDeleteReponseTime.txt', $info['total_time']."\n", FILE_APPEND);
            return new Response(
                'go checker le fichier graphqlGetDump.txt',
                Response::HTTP_OK,
                array('content-type' => 'text/html')
            );
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
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $content = curl_exec($ch);
        if($content)
        {
            $info = curl_getinfo($ch);
            curl_close($ch);
            file_put_contents('../../graphqldeleteRequestSize.txt', $info['request_size']."\n", FILE_APPEND);
            file_put_contents('../../graphqlDeleteReponseTime.txt', $info['total_time']."\n", FILE_APPEND);
            return new Response(
                'go checker le fichier graphqlDeleteReponseTime.txt',
                Response::HTTP_OK,
                array('content-type' => 'text/html')
            );
        }

        return null;
    }
}
