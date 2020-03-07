<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Credentials;
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
        $MENT3 = new User();
        $MENT3  ->setUsername('MENT3')
                ->setPassword($this->encoder->encodePassword($MENT3, "hhhhhhhh"))
                ->setRoles(array("ROLE_ADMIN"));
            
        $manager->persist($MENT3);
        
        $Sheraw = new User();
        $Sheraw ->setUsername('Sheraw')
                ->setPassword($this->encoder->encodePassword($Sheraw, "hhhhhhhh"))
                ->setRoles(array("ROLE_USER"));

        $manager->persist($Sheraw);

        
        $MENT3_PASSWORD = new Credentials();
        $MENT3_PASSWORD ->setUrl("facebook")
                        ->setLogin('login')
                        ->setPassword($this->encoder->encodePassword($MENT3, 'password'))
                        ->setUser($MENT3);

        $manager->persist($MENT3_PASSWORD);

        $Sheraw_PASSWORD = new Credentials();
        $Sheraw_PASSWORD ->setUrl("facebook")
                        ->setLogin('login')
                        ->setPassword($this->encoder->encodePassword($Sheraw, 'password'))
                        ->setUser($Sheraw);
                        
        $manager->persist($Sheraw_PASSWORD);

        $manager->flush();
    }
}
