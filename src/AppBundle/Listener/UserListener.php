<?php
namespace AppBundle\Listener;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent,
    Symfony\Component\HttpKernel\Event\GetResponseEvent,
    Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Request;


class UserListener
{

    /**
     * security.interactive_login event. If a user chose a locale in preferences, it would be set,
     * if not, a locale that was set by setLocaleForUnauthenticatedUser remains.
     *
     * @param \Symfony\Component\Security\Http\Event\InteractiveLoginEvent $event
     */
    public function setLocaleForAuthenticatedUser(InteractiveLoginEvent $event)
    {

        $user = $event->getAuthenticationToken()->getUser();
        $request = $event->getRequest();
        $event->getRequest()->setLocale($user->getLocale());
        $request->getSession()->set('_locale', $user->getLocale());

    }
}




