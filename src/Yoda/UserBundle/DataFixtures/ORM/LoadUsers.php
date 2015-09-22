<?php

namespace Yoda\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Yoda\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * Class LoadEvents
 * @package Yoda\EventBundle\DataFixtures\ORM
 */
class LoadUsers implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('darth');
        $user->setPassword($this->encodePassword($user, 'pass'));
        $user->setIsActive(false);
        $manager->persist($user);

        $user1 = new User();
        $user1->setUsername('vikbert');
        $user1->setPassword($this->encodePassword($user1, 'pass'));
        $user1->setIsActive(true);
        $user1->setEmail('me@me.com');
        $manager->persist($user1);
        
        $user2 = new User();
        $user2->setUsername('demo');
        $user2->setPassword($this->encodePassword($user2, 'pass'));
        $user2->setIsActive(false);
        $manager->persist($user2);

        $manager->flush();
    }

    /**
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param User $user
     * @param string $plainPassword
     * @return string
     */
    private function encodePassword(User $user, $plainPassword)
    {
        $encoder = $this->container->get('security.encoder_factory')
            ->getEncoder($user);

        return $encoder->encodePassword($plainPassword, $user->getSalt());
    }
}
