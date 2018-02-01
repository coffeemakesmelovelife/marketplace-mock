<?php

namespace AppBundle\Controller\Backoffice;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Services\CategoryManager;
use AppBundle\Entity\Category;
use AppBundle\Form\CategoryType;

class CategoryController extends Controller
{

  /**
   * @Route("/admin/categories", name="categories")
   */
  public function listAction(Request $request, CategoryManager $categoryManager)
  {

    $categories = $categoryManager->findAll();
   
    return $this->render('backoffice/categories.html.twig', [
      'categories' => $categories
    ]);
  }

  /**
   * @Route("/admin/add-category", name="addcategory")
   */
   public function addAction(Request $request, CategoryManager $categoryManager)
   {

    $category = new Category();


        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $params = $request->request->get('category');
            $categoryManager->createCategory($params);
        }
    

     return $this->render('backoffice/categoryform.html.twig', [
       'form' => $form->createView(),
       'action' => 'Create'
     ]);
   }

  /**
   * @Route("/admin/edit-category/{id}", name="editcategory")
   * @ParamConverter("category", class="AppBundle:Category", options={"mapping"={"id"="id"}})
   * @Method({"GET","PUT"})
   */
  public function editAction(Request $request, Category $category, CategoryManager $categoryManager)
  {

   $form = $this->createForm(CategoryType::class, $category, ['method' => 'PUT']);

   $form->handleRequest($request);

   if($form->isSubmitted() && $form->isValid())
   {
       $params = $request->request->get('category');
       $categoryManager->updateCategory($category, $params); 
       
   }
   
    return $this->render('backoffice/categoryform.html.twig', [
      'form' => $form->createView(),
      'action' => 'Create'
    ]);
  }

   /**
   * @Route("/admin/categories/{id}", name="deletecategory", requirements={"id"="\d+"})
   * @ParamConverter("category", class="AppBundle:Category", options={"mapping"={"id"="id"}})
   * @Method({"DELETE"})
   */
  public function deleteAction(Request $request, Category $category, CategoryManager $categoryManager)
  {
    if($category == null)
    {
      throw $this->createNotFoundException(Category::NOT_FOUND);
    }

    $categoryManager->deleteCategory($category);

    return new JsonResponse(Category::DELETED_SUCCESS, 200);
  }

   
}

