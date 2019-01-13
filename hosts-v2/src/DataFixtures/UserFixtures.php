<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * UserFixtures constructor.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    
    public function load(ObjectManager $manager)
    {
        $macron = new User();
        $macron->setPassword($this->encoder->encodePassword($macron, 'macron'));
        $macron->setEmail('macron@macron.com');
        $macron->setTelephone(0606060606);
        $macron->setRoles(['ROLE_HOST']);
        $manager->persist($macron);
        $this->addReference('macron', $macron);

        $trump = new User();
        $trump->setPassword($this->encoder->encodePassword($trump, 'trump'));
        $trump->setEmail('trump@trump.com');
        $trump->setTelephone(020204747472);
        $trump->setRoles(['ROLE_ADMIN']);
        $manager->persist($trump);
        $this->addReference('trump', $trump);

        $validmir = new User();
        $validmir->setPassword($this->encoder->encodePassword($validmir, 'poutine'));
        $validmir->setEmail('poutine@poutine.com');
        $validmir->setTelephone(0303030303);
        $validmir->setRoles(['ROLE_HOST']);
        $manager->persist($validmir);
        $this->addReference('vlad', $validmir);

        $kim = new User();
        $kim->setPassword($this->encoder->encodePassword($kim, 'kim'));
        $kim->setEmail('kim@kim.com');
        $kim->setTelephone(0606060606);
        $manager->persist($kim);

        $manager->flush();
    }
}
