<?php


namespace AppBundle\EventListener;

use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class LoginListener {

    private $securityContext;
    private $router;
    private $dispatcher;

    public function __construct(AuthorizationCheckerInterface $securityContext, Router $router, EventDispatcherInterface $dispatcher) {
        $this->securityContext = $securityContext;
        $this->router = $router;
        $this->dispatcher = $dispatcher;
    }
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event) {
        if ($this->securityContext->isGranted ( 'IS_AUTHENTICATED_FULLY' )) {
            $user = $event->getAuthenticationToken ()->getUser ();

            if ($user->getLastLogin () === null) {
                $this->dispatcher->addListener ( KernelEvents::RESPONSE, array (
                    $this,
                    'onKernelResponse'
                ) );
            }
        }
    }
    public function onKernelResponse(FilterResponseEvent $event) {
        $response = new RedirectResponse ( $this->router->generate ( 'fos_user_change_password' ) );
        $event->setResponse ( $response );
    }
}