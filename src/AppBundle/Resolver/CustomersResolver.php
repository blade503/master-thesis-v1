<?php

namespace AppBundle\Resolver;

use AppBundle\Repository\CustomerRepository;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

final class CustomersResolver implements ResolverInterface, AliasedInterface
{
    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    /**
     *
     * @param CustomerRepository $customerRepository
     */
    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * @return array
     */
    public function resolve()
    {
        return $this->customerRepository->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public static function getAliases()
    {
        return [
            'resolve' => 'Customers',
        ];
    }
}