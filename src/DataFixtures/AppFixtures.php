<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('admin')
                ->setEmail('admin@gmail.com')
                ->setName('Admin')
                ->setLastName('Admin')
                ->setGender('mail')
                ->setIsActive(1)
                ->setRoles(['ROLE_ADMIN'])
                ->setRegisterDate(new \DateTime())
                ->setCountry('Canada');

        $password = $this->encoder->encodePassword($user, '123123');
        $user->setPassword($password);

        $manager->persist($user);
        $manager->flush();
    }
}

