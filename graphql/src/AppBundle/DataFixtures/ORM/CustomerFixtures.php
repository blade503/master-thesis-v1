<?php

namespace AppBundle\DataFixtures\ORM;

require_once '/Users/alexandre/Documents/mamp/master-thesis-v1/graphql/vendor/fzaninotto/faker/src/autoload.php';

use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Customer;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;

class CustomerFixtures implements ORMFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 500; $i++) {
            $customer = new Customer($faker->firstName, $faker->lastName, $faker->city, $faker->country, $faker->ssn, $faker->phoneNumber);
            $manager->persist($customer);
        }

        $manager->flush();
    }
}