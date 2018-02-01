<?php

namespace AppBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserManager
{
    private $container;
    private $passwordEncoder;

    public function __construct(Container $container, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->container = $container;
        return $this;
    }


    /**
     * update user
     *
     * @param object $user
     * @param array $params
     *
     * @return array
     */
    public function updateUser($user, $params)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $user->setUsername($params['username']);
        $user->setEmail($params['email']);

        if ($params['password']) {
            $password = $this->passwordEncoder->encodePassword($user, $params['password']);
            $user->setPassword($password);
        }

        $em->persist($user);
        $em->flush();

        return $params;
    }
}
