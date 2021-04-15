<?php

namespace App\DataFixtures;

use App\Entity\CustomerUser;
use App\Repository\CustomerRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CustomerUserFixtures extends Fixture implements DependentFixtureInterface
{
    /** @var CustomerRepository */
    private $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function load(ObjectManager $manager)
    {
        $customersUsers = [
            ['email' => 'client1@gmail.com', 'firstname' => 'John', 'lastname' => 'Doe', 'password' => 'motdepasse'],
            ['email' => 'client2@gmail.com', 'firstname' => 'John', 'lastname' => 'Doe', 'password' => 'motdepasse'],
            ['email' => 'client3@gmail.com', 'firstname' => 'John', 'lastname' => 'Doe', 'password' => 'motdepasse'],
        ];

        $customers = $this->customerRepository->findAll();

        foreach ($customers as $customer) {

            foreach ($customersUsers as $c) {
                $customerUser = new CustomerUser();

                $customerUser->setEmail($c['email'])
                    ->setFirstname($c['firstname'])
                    ->setLastname($c['lastname'])
                    ->setPassword($c['password'])
                    ->setCustomer($customer);

                $manager->persist($customerUser);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CustomerFixtures::class
        ];
    }
}
