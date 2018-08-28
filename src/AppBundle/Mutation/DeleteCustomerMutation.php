<?php

namespace AppBundle\Mutation;

use AppBundle\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;
use AppBundle\Entity\Customer;

final class DeleteCustomerMutation implements MutationInterface, AliasedInterface
{
    private $em;

    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    public function __construct(EntityManagerInterface $em, CustomerRepository $customerRepository)
    {
        $this->em = $em;
        $this->customerRepository = $customerRepository;
    }

    public function resolve($id)
    {
        $customer = $this->customerRepository->find($id);
        $this->em->remove($customer);
        $this->em->flush();

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public static function getAliases()
    {
        return [
            'resolve' => 'DeleteCustomer',
        ];
    }
}