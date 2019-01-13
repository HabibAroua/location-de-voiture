<?php
namespace AppBundle\Listener;

use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\HttpKernel;
use  AppBundle\Entity\User;

/**
 * Listener that updates the last activity of the authenticated user
 */
class ActivityListener
{
    protected $tokenStorage;
    protected $em;

    public function __construct(TokenStorage $tokenStorage, EntityManager $manager)
    {
        $this->tokenStorage = $tokenStorage;
        $this->em = $manager;
    }

    /**
     * Update the user "lastActivity" on each request
     * @param FilterControllerEvent $event
     */
    public function onCoreController(FilterControllerEvent $event)
    {
        // Check that the current request is a "MASTER_REQUEST"
        // Ignore any sub-request
        if ($event->getRequestType() !== HttpKernel::MASTER_REQUEST) {
            return;
        }

        // Check token authentication availability
        if ($this->tokenStorage->getToken()) {
            $user = $this->tokenStorage->getToken()->getUser();
            $delay = new \DateTime();
            $delay->setTimestamp(strtotime('2 minutes ago'));
            if ($user instanceof User && $user->getLastActivityAt() < $delay) {
                $user->isActiveNow();
                $this->em->flush($user);
            }
        }
    }
}