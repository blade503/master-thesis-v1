<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EditController extends Controller
{
    /**
     * @Route("/rest/edit-customer/{id}", name="rest_edit_customer")
     */
    public function restEditAction(Request $request)
    {
        $data = array(
            "firstName"=>"toto",
            "lastName"=>"titi",
            "city"=>"paris",
            "country"=>"France",
            "socialSecurityNumber"=>"1940821422294",
            "mobile"=>"0660920377"
        );

        $ch = curl_init('http://localhost:8888/thesis/rest/web/app_dev.php/customers/'.$request->get('id'));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
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
     * @Route("/graphql/edit-customer/{id}", name="graphq_edit_customer")
     */
    public function graphqlEditAction(Request $request)
    {
        $data = array(
            'operationName' => 'EditCustomer',
            'query'=> 'mutation EditCustomer($editCustomer: EditCustomerInput!) { EditCustomer(id: '.$request->get('id').', input: $editCustomer) { id lastName firstName email city country socialSecurityNumber mobile salary createdAt }}',
            'variables'=> '{"editCustomer": {"firstName": "henry", "lastName": "modifie", "city": "londres"}}'
        );

        $ch = curl_init('http://localhost:8888/thesis/graphql/web/app_dev.php/graphql');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 'POST');
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
