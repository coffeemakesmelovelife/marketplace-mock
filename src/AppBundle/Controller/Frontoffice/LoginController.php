<?php

namespace AppBundle\Controller\Frontoffice;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use AppBundle\Entity\User;
use AppBundle\Form\LoginForm;


class LoginController extends Controller
{
  /**
   * @Route("/login", name="user_login")
   */
   public function loginAction(Request $request, AuthenticationUtils $authUtils)
   {

     $lastUser = $authUtils->getLastUsername();

     return $this->render('frontoffice/login.html.twig', [
       'lastUser' => $lastUser
     ]);
   }

}
