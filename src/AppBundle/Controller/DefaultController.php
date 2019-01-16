<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DefaultController extends Controller
{



    /**
     * @Route("/login", name="login")
     */
    public function fbAction(Request $request)
    {

        $fb_login = $this->get('fb_sdk');
        $fb = $fb_login->create();
        $host = $request->getBaseUrl();
        $loginUrl = $fb_login->redirectLoginHelper->getLoginUrl("http://$host/fb-callback/", ['email']);

        return $this->render('FOSUserBundle:Security:login.html.twig', ['loginUrl' => $loginUrl]);
    }

    /**
     * @Route("/fb-callback/", name="fb-callback")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function fbCallbackAction(Request $request)
    {
    }

    /**
     * @Route("/fb-access", name="fb-access")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function fbAccessAction(Request $request)
    {
        return $this->render('SuerAdmin/dashbaord.html.twig');
    }

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/admin", name="AdminPage")
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     */
    public function testSuperAdmin(Request $request){
        return $this->render('SuperAdmin/dashboard.html.twig');
    }

    /**
     * @Route("/client", name="ClientPage")
     * @Security("has_role('ROLE_CLIENT')")
     */
    public function TestClientAction()
    {
        $this->denyAccessUnlessGranted('ROLE_CLIENT');
        // replace this example code with whatever you need
        return $this->render('Client/dashboard.html.twig');

    }

    /**
     * @Route("/manager", name="ManagerPage")
     * @Security("has_role('ROLE_MANAGER')")
     */
    public function TestManagerAction()
    {
        $this->denyAccessUnlessGranted('ROLE_MANAGER');
        // replace this example code with whatever you need
    }

        /**
     * @Route("/admin/test", name="testRoleAdmin")
     */
    public function  testRoleAdmin(Request $request){
        return $this->render('ExemplesRoles/helloadmin.html.twig');
    }
}
