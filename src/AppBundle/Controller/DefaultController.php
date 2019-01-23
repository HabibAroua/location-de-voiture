<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Caracteristique;
use AppBundle\Entity\Voiture;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Form\contactType;
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
        $voitures = $this->getDoctrine()->getRepository(Voiture::class)->findAll();
        $caracteristiques = $this->getDoctrine()->getRepository(Caracteristique::class)->findAll();
        return $this->render('default/index.html.twig', ['voitures'=>$voitures,
                                'caracteristiques'=>$caracteristiques,'loginUrl' => $loginUrl]);
    }

    /**
     * @Route("/contact", name="contact")
     * @Method({"GET", "POST"})
     */
    public function contactAction(Request $request){

        $form = $this->createForm('AppBundle\Form\contactType',null,array(
            // To set the action use $this->generateUrl('route_identifier')
           // 'action' => $this->generateUrl('contact'),
        ));

        if ($request->isMethod('POST')) {
            // Refill the fields in case the form is not valid.
            $form->handleRequest($request);

            if($form->isValid()){
                // Send mail
                if($this->sendEmail($form->getData())){

                    // Everything OK, redirect to wherever you want ! :

                    return $this->redirectToRoute('homepage');

                }
            }
        }

        return $this->render('Email/contact.html.twig', array(
            'form' => $form->createView(),

        ));
    }

    private function sendEmail($data){
        $myappContactMail = 'cherniyosser95@gmail.com';
        $myappContactPassword = 'mk22532432';

        // In this case we'll use the ZOHO mail services.
        // If your service is another, then read the following article to know which smpt code to use and which port
        // http://ourcodeworld.com/articles/read/14/swiftmailer-send-mails-from-php-easily-and-effortlessly
        $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465,'ssl')
            ->setUsername($myappContactMail)
            ->setPassword($myappContactPassword);

        $mailer = \Swift_Mailer::newInstance($transport);

        $message = \Swift_Message::newInstance( $data["subject"])
            ->setFrom(array($myappContactMail => "Message by ".$data["name"]))
            ->setTo(array(
                $myappContactMail => $myappContactMail
            ))
            ->setBody($data["message"]." Send Via : " .$data["email"]);

        return $mailer->send($message);
    }


    /**
     * @Route("/company", name="company")
     */
    public function companyAction(){
        return $this->render('company.html.twig');
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
