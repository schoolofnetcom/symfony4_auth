<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserRepository extends ServiceEntityRepository implements UserLoaderInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Loads the user for the given username.
     *
     * This method must return null if the user is not found.
     *
     * @param string $username The username
     *
     * @return UserInterface|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder("u")
            ->where("u.username = :username or u.email = :email")
            ->setParameter("username", $username)
            ->setParameter("email", $username)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
