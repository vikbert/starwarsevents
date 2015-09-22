<?php

namespace Yoda\UserBundle;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Yoda\UserBundle\Entity\User;

/**
 * Class UserUtils
 * @package Yoda\UserBundle
 */
class UserUtils
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param User $user
     * @param string $password
     * @return string
     */
    public function encodePassword(User $user, $password)
    {
        $encoder = $this->container->get('security.encoder_factory')
            ->getEncoder($user);

        return $encoder->encodePassword($password, $user->getSalt());
    }
}