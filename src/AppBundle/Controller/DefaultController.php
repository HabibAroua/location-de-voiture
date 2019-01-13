<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DefaultController extends Controller
{
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
