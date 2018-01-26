<?php

namespace AppBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Listing;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ListingManager
{
    private $container;

    public function __construct(Container $container, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->container = $container;
        return $this;
    }


  /**
   * create listing
   *
   * @param array $params
   * @param object $user
   *
   * @return ListingManager
   */
    public function createListing($user, $params)
    {
        $listing = new Listing();

        $listing->setName($params['name']);
        $listing->setPrice($params['price']);
        $listing->setSize($params['size']);
        $listing->setUser($user);

        $em = $this->container->get('doctrine.orm.entity_manager');
        $em->persist($listing);
        $em->flush();

        return $this;
    }
}