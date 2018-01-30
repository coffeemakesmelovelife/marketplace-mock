<?php

namespace AppBundle\Controller\Backoffice;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Services\CategoryManager;
use AppBundle\Entity\Category;
use AppBundle\Form\CategoryType;
use AppBundle\Form\LoginForm;


class CategoryController extends Controller
{
  /**
   * @Route("/admin/add-category", name="addcategory")
   */
   public function addAction(Request $request, CategoryManager $categoryManager)
   {

    $category = new Category();

    $form = $this->createForm(CategoryType::class, $category);

    if($request->getMethod() == 'POST')
    {
        $params = $request->request->get('category');
        $categoryManager->createCategory($params);

    }
     
    
     return $this->render('backoffice/newcategory.html.twig', [
       'form' => $form->createView()
     ]);
   }

}