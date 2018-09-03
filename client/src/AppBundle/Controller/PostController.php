<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
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

    /**
     * @Route("/graphql/post-customer", name="graphq_post_customer")
     */
    public function graphqlPostAction(Request $request)
    {
        $data = array(
            'operationName' => 'NewCustomer',
            'query'=> 'mutation NewCustomer($newCustomer: NewCustomerInput!) {  NewCustomer(input: $newCustomer) { id lastName firstName email city country socialSecurityNumber mobile salary createdAt }}',
            'variables'=> '{"newCustomer": {"firstName": "henry", "lastName": "modifie", "city": "londres", "country": "England", "socialSecurityNumber": "194087521422275", "mobile": "0660920377"}}'
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
