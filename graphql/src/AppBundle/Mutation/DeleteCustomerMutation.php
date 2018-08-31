<?php

namespace AppBundle\Mutation;

use AppBundle\Repository\CustomerRepository;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;

final class DeleteCustomerMutation implements MutationInterface, AliasedInterface
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
     * @return bool
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function resolve($id)
    {
        return $this->customerRepository->deleteCustomer($id);
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