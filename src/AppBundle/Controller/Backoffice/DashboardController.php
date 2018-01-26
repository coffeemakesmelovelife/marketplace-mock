<?php

namespace AppBundle\Controller\Backoffice;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;



class DashboardController extends Controller
{

   /**
    * @Route("/admin", name="dashboard")
    */
    public function dashboardAction()
    {

      return $this->render('backoffice/dashboard.html.twig', [

      ]);
    }
}
