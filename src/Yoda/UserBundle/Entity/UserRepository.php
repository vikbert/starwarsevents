<?php

namespace Yoda\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository implements UserProviderInterface
{
    /**
     * @param string $name
     * @return null|User
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneByUsernameOrEmail($name)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.username = :username OR u.email =:email')
            ->setParameter('username', $name)
            ->setParameter('email', $name)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function loadUserByUsername($username)
    {
        $user = $this->findOneByUsernameOrEmail($username);

        if (!$user) {
            throw new UsernameNotFoundException('No user found for '. $username);
        }

        return $user;
    }

    /**
     * @param UserInterface $user
     * @return null|object
     */
    public function refreshUser(UserInterface $user)
    {
        /** @var User $class */
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(sprintf(
                'Instance of "%s" are not supported.',
                $class
            ));
        }

        if (!$refreshedUser = $this->find($user->getId())) {
            throw new UsernameNotFoundException(sprintf('User with id %s not found', $user->getUsername()));
        }

        return $refreshedUser;
    }

    /**
     * @param User $class
     * @return bool
     */
    public function supportsClass($class)
    {
        $entityName = $this->getEntityName();

        return $entityName === $class || is_subclass_of($class, $entityName);
    }
}
