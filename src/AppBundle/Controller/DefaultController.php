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
    public function fbAction(Request $request)
    {
        $fb_login = $this->get('fb_sdk');
        $fb = $fb_login->create();
        $host = $this->getParameter('host');
        $loginUrl = $fb_login->redirectLoginHelper->getLoginUrl("http://$host/fb-callback/", ['email']);

        return $this->render('default/index.html.twig', ['loginUrl' => $loginUrl]);
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
     * @Route("/email", name="email_form")
     */
    public function emailFormAction(Request $request)
    {
        $user = $this->getUser();

        $form = $this->createForm('AppBundle\Form\User\UserFacebookType', $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('homepage', array('id' => $user->getId()));
        }
        /*return $this->render('default/form.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));*/
    }


    /**
     * @Route("/client", name="client")
     */
    public function clientDashboard(){
        return $this->render('facebook.html.twig');
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
        return $this->render('facebook.html.twig');
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
