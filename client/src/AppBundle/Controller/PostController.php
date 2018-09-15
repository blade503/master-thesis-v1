<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends Controller
{
    /**
     * @Route("/rest/post-customer", name="rest_post_customer")
     */
    public function restPostAction(Request $request)
    {
        $data = array(
            "firstName"=>"Anthony",
            "lastName"=>"Kavanagh",
            "city"=>"New-York",
            "country"=>"Etats-Unis",
            "socialSecurityNumber"=>"1940821422294",
            "mobile"=>"0660920377"
        );
        $ch = curl_init($this->container->getParameter('base_url').'rest/web/app_dev.php/customers');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $content = curl_exec($ch);
        if($content)
        {
            $info = curl_getinfo($ch);
            curl_close($ch);
            file_put_contents('../../restPostRequestSize.txt', $info['request_size']."\n", FILE_APPEND);
            file_put_contents('../../restPostReponseTime.txt', $info['total_time']."\n", FILE_APPEND);
            return new Response(
                'go checker le fichier graphqlGetDump.txt',
                Response::HTTP_OK,
                array('content-type' => 'text/html')
            );
        }

        return null;
    }

    /**
     * @Route("/graphql/post-customer", name="graphq_post_customer")
     */
    public function graphqlPostAction(Request $request)
    {
        $data = array(
            'operationName' => 'NewCustomer',
            'query'=> 'mutation NewCustomer($newCustomer: NewCustomerInput!) {  NewCustomer(input: $newCustomer) { id lastName firstName email city country socialSecurityNumber mobile salary createdAt }}',
            'variables'=> '{"newCustomer": {"firstName": "Anthony", "lastName": "Kavanagh", "city": "New-York", "country": "Etats-Unis", "socialSecurityNumber": "1940821422294", "mobile": "0660920377"}}'
        );

        $ch = curl_init($this->container->getParameter('base_url').'graphql/web/app_dev.php/graphql');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $content = curl_exec($ch);
        if($content)
        {
            $info = curl_getinfo($ch);
            curl_close($ch);
            file_put_contents('../../graphqlPostRequestSize.txt', $info['request_size']."\n", FILE_APPEND);
            file_put_contents('../../graphqlPostReponseTime.txt', $info['total_time']."\n", FILE_APPEND);
            return new Response(
                'go checker le fichier graphqlPostDump.txt',
                Response::HTTP_OK,
                array('content-type' => 'text/html')
            );
        }

        return null;
    }
}
