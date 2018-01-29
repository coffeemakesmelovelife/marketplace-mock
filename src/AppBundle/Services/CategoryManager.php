<?php

namespace AppBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Category;

class CategoryManager
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
        return $this;
    }


  /**
   * create category
   *
   * @param array $params
   *
   * @return CategoryManager
   */
    public function createCategory($params)
    {
        $category = new Category();

        $category->setName($params['name']);
        $category->setDescription($params['description']);
        $em = $this->container->get('doctrine.orm.entity_manager');
        $em->persist($category);
        $em->flush();

        return $this;
    }

  /**
    * get categories
    *
    *
    * @return array
    */
    public function findAll()
    {
        
    $em = $this->container->get('doctrine.orm.entity_manager');
    $categories = $em->getRepository('AppBundle:Category')->findAll();
    
    return $categories;
    }
}