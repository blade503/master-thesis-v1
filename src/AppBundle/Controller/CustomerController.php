<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Customer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

class CustomerController extends Controller
{
    /**
     * @Rest\View()
     * @Rest\Get("/customers")
     */
    public function getCustomersAction(Request $request)
    {
        $customers = $this->get('doctrine.orm.entity_manager')
            ->getRepository(Customer::class)
            ->findAll();

        return $customers;
    }

    /**
     * @Rest\View()
     * @Rest\Get("/customers/{id}")
     */
    public function getCustomerAction(Request $request)
    {
        $customer = $this->get('doctrine.orm.entity_manager')
            ->getRepository(Customer::class)
            ->find($request->get('id'));

        if (empty($customer)) {
            return new JsonResponse(['message' => 'Customer not found'], Response::HTTP_NOT_FOUND);
        }

        return $customer;
    }
}
