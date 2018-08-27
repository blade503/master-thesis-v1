<?php

namespace AppBundle\Mutation;

use Doctrine\ORM\EntityManagerInterface;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;
use AppBundle\Entity\Customer;

final class CustomerMutation implements MutationInterface, AliasedInterface
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function resolve($firstName, $lastName, $city, $country, $ssn, $phoneNumber)
    {
        $customer = new Customer($firstName, $lastName, $city, $country, $ssn, $phoneNumber);
        $this->em->persist($customer);
        $this->em->flush();

        return $customer;
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