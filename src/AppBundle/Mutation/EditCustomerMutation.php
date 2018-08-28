<?php

namespace AppBundle\Mutation;

use Doctrine\ORM\EntityManagerInterface;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;
use AppBundle\Entity\Customer;
use AppBundle\Repository\CustomerRepository;

final class EditCustomerMutation implements MutationInterface, AliasedInterface
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
     * @param $id
     * @param $input
     * @return null|object
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function resolve($id, $input)
    {
        return $this->customerRepository->editCustomer($id, $input);
    }

    /**
     * {@inheritdoc}
     */
    public static function getAliases()
    {
        return [
            'resolve' => 'EditCustomer',
        ];
    }
}