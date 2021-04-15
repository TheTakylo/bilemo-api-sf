<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CustomerFixtures extends Fixture
{

    /** @var UserPasswordEncoderInterface */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $customers = [
            ['companyName' => 'Marketplace 1', 'email' => 'admin@marketplace1.fr', 'password' => 'motdepasse'],
            ['companyName' => 'Marketplace 2', 'email' => 'admin@marketplace2.fr', 'password' => 'motdepasse'],
            ['companyName' => 'Marketplace 3', 'email' => 'admin@marketplace3.fr', 'password' => 'motdepasse']
        ];

        foreach ($customers as $c) {
            $customer = new Customer();

            $customer->setCompanyName($c['companyName'])
                ->setEmail($c['email'])
                ->setPassword($this->encoder->encodePassword($customer, $c['password']));

            $manager->persist($customer);
        }

        $manager->flush();
    }
}
