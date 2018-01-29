<?php

namespace AppBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Listing;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use AppBundle\Entity\Category;

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
        $em = $this->container->get('doctrine.orm.entity_manager');

        $category = $em->getRepository('AppBundle:Category')->findOneById($params['category']);

        $listing->setName($params['name']);
        $listing->setCategory($category);
        $listing->setPrice($params['price']);
        $listing->setSize($params['size']);
        $listing->setUser($user);

        $em->persist($listing);
        $em->flush();

        return $this;
    }

 /**
   * create listing
   *
   * @return array
   */
    public function findAll()
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $listings = $em->getRepository('AppBundle:Listing')->findAll();
        return $listings;
    }
}