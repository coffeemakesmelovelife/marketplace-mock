<?php

namespace AppBundle\Controller\Backoffice;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Services\ListingManager;
use AppBundle\Services\CategoryManager;
use AppBundle\Services\FileUploader;
use AppBundle\Entity\Category;
use AppBundle\Form\LoginForm;


class ListingController extends Controller
{

  /**
   * @Route("/admin/listings", name="listings")
   */
  public function displayListingsAction(Request $request, ListingManager $listingManager, CategoryManager $categoryManager)
  {
    
   $listings = $listingManager->findAll();

    return $this->render('backoffice/listings.html.twig', [
      'listings' => $listings
    ]);
  }


  /**
   * @Route("/admin/add-listing", name="addlisting")
   */
   public function addListingAction(Request $request, ListingManager $listingManager, CategoryManager $categoryManager)
   {

    if($request->getMethod() == 'POST')
    {
        $image = $request->files->get('image');
        $listingManager->createListing($this->getUser(), $request->request->all(), $image);

    }
     
    $categories = $categoryManager->findAll();

     return $this->render('backoffice/listingform.html.twig', [
       'categories' => $categories,
       'action' => 'Create',
       'form_action' => 'addlisting'
     ]);
   }

  /**
   * @Route("/admin/edit-listing/{id}", name="editlisting", requirements={"id"="\d+"})
   */
  public function editListingAction($id, Request $request, ListingManager $listingManager, CategoryManager $categoryManager)
  {
    
   if($request->getMethod() == 'POST')
   {
       $image = $request->files->get('image');
       $listingManager->updateListing($id, $request->request->all(), $image);

   }
   
   $listing = $listingManager->findOneById($id);
   $categories = $categoryManager->findAll();
   $path = $this->get('router')->generate('editlisting', array('id'=>$id));
   var_dump($path);


    return $this->render('backoffice/listingform.html.twig', [
      'categories' => $categories,
      'listing' => $listing,
      'action' => 'Edit',
      'form_action' => $path,
    ]);
  }

}
