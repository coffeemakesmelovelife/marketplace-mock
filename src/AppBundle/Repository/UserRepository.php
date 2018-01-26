<?php

namespace AppBundle\Repository;

use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use AppBundle\Entity\User;

class UserRepository extends EntityRepository implements OAuthAwareUserProviderInterface
{

  public function findAllUsers()
  {
    return $this->getEntityManager()
      ->createQuery(
        'SELECT u FROM AppBundle:User u'
        )
      ->getResult();
  }

  public function loadUserByOAuthUserResponse(UserResponseInterface $response)
  {

    $username = $response->getUsername();
    $email = $response->getEmail();
    $user = $this->getEntityManager()
                 ->createQuery(
                  "SELECT u FROM AppBundle:User u WHERE u.email= :email"
                 )
                 ->setParameter('email',$email)
                 ->getOneOrNullResult();

    if (null === $user) {
      $user = new User();
      $user->setUsername(strtolower(str_replace(' ', '', $response->getRealName())));
      $user->setEmail($response->getEmail());
      $em = $this->getEntityManager();
      $em->persist($user);
      $em->flush();
    }

    return $user;

  }



}
