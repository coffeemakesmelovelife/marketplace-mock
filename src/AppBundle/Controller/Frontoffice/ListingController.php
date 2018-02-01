<?php

namespace AppBundle\Controller\Frontoffice;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Services\ListingManager;
use AppBundle\Entity\Listing;
use AppBundle\Entity\View;

class ListingController extends Controller
{


   /**
    * @Route("/listing/{id}", name="viewlisting")
    * @ParamConverter("listing", class="AppBundle:Listing", options={"mapping"={"id"="id"}})
    */
    public function viewListingAction(Listing $listing, ListingManager $listingManager)
    {
        $listingManager->incrView($listing, $this->getUser());
        return $this->render('frontoffice/listing.html.twig', [
          'listing' => $listing
      ]);
    }


}
