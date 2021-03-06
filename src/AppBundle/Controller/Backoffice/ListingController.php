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

        if ($form->isSubmitted() && $form->isValid()) {
            $listing = $form->getData();
            $listingManager->createListing($this->getUser(), $listing);
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
    
        if ($form->isSubmitted() && $form->isValid()) {
            $listing = $form->getData();
            $listingManager->updateListing($id, $listing);
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
    if($listing == null)
    {
      throw $this->createNotFoundException(Listing::NOT_FOUND);
    }

    $listingManager->deleteListing($listing);

    return new JsonResponse(Listing::DELETED_SUCCESS, 200);
  }


}
