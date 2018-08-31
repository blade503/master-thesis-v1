<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function HomeAction(Request $request)
    {
        return new Response(
            'Je suis la page home avec le lien des différentes pages',
            Response::HTTP_OK,
            array('content-type' => 'text/html')
        );
    }
}
