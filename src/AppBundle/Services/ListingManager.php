<?php

namespace AppBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Listing;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use AppBundle\Entity\Category;
use AppBundle\Entity\View;
use AppBundle\Services\FileUploader;

class ListingManager
{
    private $container;

    private $fileUploader;

    public function __construct(Container $container, UserPasswordEncoderInterface $passwordEncoder, FileUploader $fileUploader)
    {
        $this->container = $container;
        $this->fileUploader = $fileUploader;
        return $this;
    }


    /**
      * find all listings
      *
      * @return array
      */
    public function findAll()
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $listings = $em->getRepository('AppBundle:Listing')->findAll();
        return $listings;
    }

     /**
      * find listings by user
      *
      * @param User $user
      *
      * @return array
      */
      public function findByUser($user)
      {
          $em = $this->container->get('doctrine.orm.entity_manager');
          $listings = $em->getRepository('AppBundle:Listing')
          ->findBy(array('user'=>$user));
          return $listings;
      }


    /**
      * find listing by id
      *
      * @return Listing
      */
    public function findOneById($id)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $listing = $em->getRepository('AppBundle:Listing')->findOneById($id);
        return $listing;
    }


    /**
     * create listing
     *
     * @param array $params
     * @param object $user
     *
     * @return ListingManager
     */
    public function createListing($user, $listing)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');

        $em->persist($listing);
        $em->flush();

        return $this;
    }


    /**
     * update listing
     *
     * @param int $id
     * @param array $params
     *
     * @return ListingManager
     */
    public function updateListing($id, $form)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $listing = $em->getRepository('AppBundle:Listing')->findOneById($id);
        $category = $em->getRepository('AppBundle:Category')->findOneById($form->getCategory());
      

        if ($form->getImage() != null) {
            $listing->setImage($form->getImage());
        }

        $em->flush();

        return $this;
    }

    /**
     * populate form
     *
     * @param FormType $form
     * @param int $id
     *
     * @return Form
     */
    public function populateForm($form, $id)
    {
        $listing = $this->findOneById($id);
        $form->get('name')->setData($listing->getName());
        $form->get('category')->setData($listing->getCategory());
        $form->get('price')->setData($listing->getPrice());
        $form->get('size')->setData($listing->getSize());
    
        return $form;
    }

    /**
     * delete listing
     *
     * @param Listing $listing
     * @return ListingManager
     */
    public function deleteListing($listing)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $em->remove($listing);
        $em->flush();

        return $this;
    }

    /**
     * incr view
     * 
     * @param Listing $listing
     * @param User $user
     * 
     * @return ListingManager
     */
    public function incrView($listing, $user)
    {
        $view = new View();
        $view->setListing($listing);
        $view->setUser($user);

        $em = $this->container->get('doctrine.orm.entity_manager');
        $em->persist($view);
        $em->flush();

        return $this;
    }
}
