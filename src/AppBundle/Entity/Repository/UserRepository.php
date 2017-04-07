<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use AppBundle\Entity\User;

class UserRepository extends EntityRepository implements UserLoaderInterface, UserProviderInterface
{
    /**
     * @param $username
     * @return object
     */
    public function findUserByUsername($username)
    {
        return $this->findOneBy(array(
            'username' => $username
        ));
    }

    /**
     * @param $email
     * @return User
     */
    public function findUserByEmail($email)
    {
        return $this->findOneBy(array(
            'email' => $email
        ));
    }

    /**
     * @return User
     */
    public function findAny()
    {
        return $this->createQueryBuilder('u')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function loadUserByUsername($username)
    {
      var_dump($username);exit;
      $q = $this
        ->createQueryBuilder('u')
        ->where('u.username = :username OR u.email = :email')
        ->setParameter('username', $username)
        ->setParameter('email', $username)
        ->getQuery()
      ;

      try {

        $user = $q->getSingleResult();

      } catch (NoResultException $e) {

        throw new UsernameNotFoundException(sprintf('Unable to find an active admin AppBundle:User object identified by "%s".', $username), null, 0, $e);

      }

      return $user;
    }

    public function refreshUser(UserInterface $user)
    {
      $class = get_class($user);
      if (!$this->supportsClass($class)) {
        throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $class));
      }

      return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
      return $this->getEntityName() === $class || is_subclass_of($class, $this->getEntityName());
    }
}
