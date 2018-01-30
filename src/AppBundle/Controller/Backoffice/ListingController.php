<?php

namespace AppBundle\Controller\Backoffice;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Services\ListingManager;
use AppBundle\Services\CategoryManager;
use AppBundle\Services\FileUploader;
use AppBundle\Entity\Listing;
use AppBundle\Entity\Category;
use AppBundle\Form\ListingType;


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

    $listing = new Listing();
    $form = $this->createForm(ListingType::class, $listing);

    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid())
    {        
        $listingManager->createListing($this->getUser(), $request->request->get('listing'), $form['image']->getData());
    }
     
    $categories = $categoryManager->findAll();

     return $this->render('backoffice/listingform.html.twig', [
       'form' => $form->createView(),
       'action' => 'Create',
     ]);
   }

  /**
   * @Route("/admin/edit-listing/{id}", name="editlisting", requirements={"id"="\d+"})
   */
  public function editListingAction($id, Request $request, ListingManager $listingManager, CategoryManager $categoryManager)
  {

    $listing = new Listing();
    $form = $this->createForm(ListingType::class, $listing);

    $form->handleRequest($request);
    
   if($form->isSubmitted() && $form->isValid())
   {
       $listingManager->updateListing($id, $request->request->get('listing'), $form['image']->getData());
   } else {
    $form = $listingManager->populateForm($form, $id);
   }

    return $this->render('backoffice/listingform.html.twig', [
      'form' => $form->createView(),
      'action' => 'Edit',
    ]);
  }

 /**
   * @Route("/admin/listings/{id}", name="deletelisting", requirements={"id"="\d+"})
   * @ParamConverter("listing", class="AppBundle:Listing", options={"mapping"={"id"="id"}})
   * @Method({"DELETE"})
   */
  public function deleteAction(Request $request, Listing $listing, ListingManager $listingManager)
  {
    try{
      $listingManager->deleteListing($listing);
    } catch(\Exception $e) {      
      error_log($e->getMessage());
      return new JsonResponse('Internal error', 500);
    }

    return new JsonResponse('Success', 200);
  }

}
