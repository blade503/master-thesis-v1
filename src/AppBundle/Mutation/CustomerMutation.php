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

    public function resolve($input)
    {
        $customer = new Customer($input['firstName'],  $input['lastName'], $input['city'], $input['country'], $input['socialSecurityNumber'], $input['mobile']);
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