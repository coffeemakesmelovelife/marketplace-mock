<?php

namespace AppBundle\Controller\Backoffice;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\User;
use AppBundle\Services\UserManager;

class DashboardController extends Controller
{

   /**
    * @Route("/admin/", name="dashboard")
    */
    public function dashboardAction()
    {
        /* 
        if(in_array('ROLE_ADMIN', $this->getUser()->getRoles()))
        {
            
        } */
        return $this->render('backoffice/dashboard.html.twig', [

      ]);
    }


    /**
    * @Route("/admin/profile", name="admin_profile")
    */
    public function profileAction(Request $request, UserManager $userManager)
    {
        if ($request->getMethod() == 'POST') {
            $userManager->updateUser($this->getUser(), $request->request->all());
        }

        return $this->render('backoffice/profile.html.twig', [
        
        ]);
    }
}
