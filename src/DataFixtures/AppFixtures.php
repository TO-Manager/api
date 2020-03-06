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

        $manager->flush();
    }
}
