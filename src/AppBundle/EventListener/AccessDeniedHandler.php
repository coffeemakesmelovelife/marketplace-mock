<?php

namespace AppBundle\EventListener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    private $router;
    private $session;
    private $container;

    public function __construct(RouterInterface $router, SessionInterface $session, Container $container)
    {
        $this->router = $router;
        $this->session = $session;
        $this->container = $container;
    }

    public function handle(Request $request, AccessDeniedException $accessDeniedException)
    {

        $user= $this->container->get('security.token_storage')->getToken()->getUser();
        if($request->getPathInfo() == '/admin/' && in_array('ROLE_USER', $user->getRoles()))
        {
            return new RedirectResponse($this->router->generate('homepage'));
        }
        //error_log($user->getRoles());
        if ($request->getPathInfo() == '/admin/login' || $request->getPathInfo() == '/admin/register')
        {
            $this->session->getFlashBag()->add('warning', 'You are already logged in!');

            return new RedirectResponse($this->router->generate('dashboard'));
        }
        
    }
}
