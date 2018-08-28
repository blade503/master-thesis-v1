<?php

namespace AppBundle\Mutation;

use AppBundle\Repository\CustomerRepository;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;
use AppBundle\Entity\Customer;

final class NewCustomerMutation implements MutationInterface, AliasedInterface
{
    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * @param $input
     * @return Customer
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function resolve($input)
    {
       return $this->customerRepository->createCustomer($input);
    }

    /**
     * {@inheritdoc}
     */
    public static function getAliases()
    {
        return [
            'resolve' => 'NewCustomer',
        ];
    }
}