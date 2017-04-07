<?php

namespace AppBundle\Provider;


use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\NoResultException;

class UserProvider implements UserProviderInterface
{
    protected $manager;

    public function __construct(ObjectManager $manager){
        $this->manager = $manager;
    }

    public function loadUserByUsername($username)
    {
        
        $q = $this->manager->getRepository("AppBundle:User")
            ->createQueryBuilder('u')
            ->where('u.username = :username OR u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery();

        try {
            $user = $q->getSingleResult();
        } catch (NoResultException $e) {
            $message = sprintf(
                'Unable to find an active admin AcmeDemoBundle:User object identified by "%s".',
                $username
            );
            throw new UsernameNotFoundException($message, 0, $e);
        }

        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(
                sprintf(
                    'Instances of "%s" are not supported.',
                    $class
                )
            );
        }

        return $this->manager->getRepository("AppBundle:User")->find($user->getId());
    }

    public function supportsClass($class)
    {
        return $this->manager->getRepository("AppBundle:User")->getClassName() === $class
        || is_subclass_of($class, $this->manager->getRepository("AppBundle:User")->getClassName());
    }
}