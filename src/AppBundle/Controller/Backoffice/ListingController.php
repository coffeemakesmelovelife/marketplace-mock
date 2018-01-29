<?php

namespace AppBundle\Controller\Backoffice;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Services\ListingManager;
use AppBundle\Services\CategoryManager;
use AppBundle\Entity\Category;
use AppBundle\Form\LoginForm;


class ListingController extends Controller
{
  /**
   * @Route("/admin/add-listing", name="addlisting")
   */
   public function addAction(Request $request, ListingManager $listingManager, CategoryManager $categoryManager)
   {

    if($request->getMethod() == 'POST')
    {

        $listingManager->createListing($this->getUser(), $request->request->all());

    }
     
    $categories = $categoryManager->findAll();

     return $this->render('backoffice/newlisting.html.twig', [
       'categories' => $categories
     ]);
   }

}
