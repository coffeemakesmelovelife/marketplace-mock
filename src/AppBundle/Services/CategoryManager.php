<?php

namespace AppBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Category;

class CategoryManager
{
    private $container;
    private $em;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->em = $this->container->get('doctrine.orm.entity_manager');
        return $this;
    }


  /**
   * update category
   *
   * @param Category
   * @param array $params
   *
   * @return CategoryManager
   */
    public function updateCategory($category, $params)
    {
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

 /**
   * delete category
   * 
   * 
   * @return CategoryManager
   *  
   */
    public function deleteCategory($category)
    {
        $this->em->remove($category);
        $this->em->flush();

        return $this;
    }
}