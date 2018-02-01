<?php

namespace AppBundle\Controller\Frontoffice;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Form\RegisterForm;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class RegisterController extends Controller
{
  /**
   * @Route("/register", name="user_register")
   */
   public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
   {

     $user = new User();

     $form = $this->createForm(RegisterForm::class, $user);
     $form->handleRequest($request);

     if ($form->isSubmitted() && $form->isValid())
     {
      $firewall = $this->container
      ->get('security.firewall.map')
      ->getFirewallConfig($request)
      ->getName();
       $firewall == 'admin' ? $role = 'ROLE_ADMIN' : $role = 'ROLE_USER';
       $user->setRoles([$role]);

       $password = $passwordEncoder->encodePassword($user, $user->getPassword());
       $user->setPassword($password);

       $em = $this->getDoctrine()->getManager();
       $em->persist($user);
       $em->flush();

       return $this->redirectToRoute('user_login');
     }


     return $this->render('frontoffice/register.html.twig', [
       'form' => $form->createView()
     ]);
   }

}
