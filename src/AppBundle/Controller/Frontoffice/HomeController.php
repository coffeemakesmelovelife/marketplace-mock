<?php

namespace AppBundle\Controller\Frontoffice;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\User;
use AppBundle\Services\ListingManager;

class HomeController extends Controller
{

   /**
    * @Route("/", name="homepage")
    */
    public function dashboardAction(ListingManager $listingManager)
    {
        $listings = $listingManager->findAll();
        return $this->render('frontoffice/index.html.twig', [
          'listings' => $listings
      ]);
    }

}
