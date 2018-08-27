<?php

namespace AppBundle\Resolver;

use AppBundle\Repository\CustomerRepository;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

final class CustomerResolver implements ResolverInterface, AliasedInterface
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
     * @param $id
     *
     * @return null|object
     */
    public function resolve($id)
    {
        return $this->customerRepository->find($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function getAliases()
    {
        return [
            'resolve' => 'Customer',
        ];
    }
}