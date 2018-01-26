<?php

namespace AppBundle\Controller\Backoffice;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Services\ListingManager;
use AppBundle\Entity\Listing;
use AppBundle\Form\LoginForm;


class ListingController extends Controller
{
  /**
   * @Route("/admin/add-listing", name="addlisting")
   */
   public function addAction(Request $request, ListingManager $listingManager)
   {

    if($request->getMethod() == 'POST')
    {

        var_dump($request->request->all());
        $listingManager->createListing($this->getUser(), $request->request->all());

    }
     
     

     return $this->render('backoffice/newlisting.html.twig', [
       
     ]);
   }

}
