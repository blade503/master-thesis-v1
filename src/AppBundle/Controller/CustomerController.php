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
     *
     * @param Request $request
     * @return Customer|null|object|JsonResponse
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

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/customers")
     *
     * @param Request $request
     * @return mixed
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function postCustomersAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $customer = $em->getRepository(Customer::class)->createCustomer($request->request->all(), 'REST');

        $em->persist($customer);
        $em->flush();

        return $customer;
    }

    /**
     * @Rest\View()
     * @Rest\Put("/customers/{id}")
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Doctrine\ORM\ORMException
     */
    public function putCustomerAction(Request $request)
    {
        $customerRepository = $this->get('doctrine.orm.entity_manager')->getRepository(Customer::class);
        $customer = $customerRepository->find($request->get('id'));

        if (empty($customer)) {
            return new JsonResponse(['message' => 'Customer not found'], Response::HTTP_NOT_FOUND);
        }

        $customerRepository->editCustomer($request->get('id'), $request, 'REST');
        return $customer;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/customers/{id}")
     *
     * @param Request $request
     * @throws \Doctrine\ORM\ORMException
     */
    public function removeCustomerAction(Request $request)
    {
        $this->get('doctrine.orm.entity_manager')->getRepository(Customer::class)->deleteCustomer($request->get('id'));
    }
}
