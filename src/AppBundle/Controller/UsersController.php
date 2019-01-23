<?php
namespace AppBundle\Controller;
use AppBundle\Entity\User;
use AppBundle\Form\User\UserRoleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Form\User\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class UsersController
 * @package AppBundle\Controller
 */
class UsersController extends Controller
{
    /**
     * List all Managers
     *
     * @Route("/managers", name="Manager")
     */
    public function indexManagers()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT u.id, u.username, u.email, u.phoneNumber, u.roles FROM AppBundle:User u where u.roles LIKE :role')
            ->setParameter('role', '%"ROLE_MANAGER"%');
        $managers = $query->getResult();
        return $this->render('Manager/index.html.twig', array(
            'managers' => $managers,
        ));
    }

    /**
     * List all clients
     *
     * @Route("/clients", name="Client")
     */
    public function indexClients()
    {

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT u.id, u.username, u.email, u.phoneNumber, u.roles FROM AppBundle:User u where u.roles LIKE :role')
            ->setParameter('role', '%"ROLE_CLIENT"%');
        $clients = $query->getResult();
        return $this->render('Client/index.html.twig', array(
            'clients' => $clients,
        ));
    }


    /**
     * Create new user
     *
     * @Route("/create-user", name="user-create")
     * @Method({"GET", "POST"})
     */
    public function createUserAction(Request $request){

        $myappContactMail = 'cherniyosser95@gmail.com';
        $myappContactPassword = 'mk22532432';

        $user = new User();
        $user->setUser($this->getUser());
    
        //$user->setRoles($this->getUser()->getRoles());
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
      
        if ($form->isSubmitted() && $form->isValid())
        {
            
            $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465,'ssl')
                ->setUsername($myappContactMail)
                ->setPassword($myappContactPassword)
                ->setStreamOptions(array('ssl' => array('allow_self_signed' => true, 'verify_peer' => false))
            );
            
            $mailer = \Swift_Mailer::newInstance($transport);
            $message = \Swift_Message::newInstance( "Nouveau compte")
                ->setFrom($myappContactMail)
                ->setTo($user->getEmail())

                ->setBody(
                    $this->renderView(
                    // app/Resources/views/Emails/registration.html.twig
                        'Email/register.html.twig',array(
                            "user" => $user
                        )
                    ),
                    'text/html'
                );
            $mailer->send($message);

            //$user = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Utilisateur enregistrer avec succées');
            
            if($request->get('roles') == "ROLE_MANAGER"){
            return $this->redirectToRoute('Manager');}
            else{
                return $this->redirectToRoute('Client');
            }
        }

        return $this->render('SuperAdmin/create.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    /**
     * @Route("{id}/edit-user", requirements={"id": "\d+"}, name="user-edit")
     * @Method({"GET", "POST"})
     */
    public function editUserAction(Request $request, User $user)
    {
        $user->setUser($this->getUser());
        $form = $this->createForm(UserRoleType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'Utilisateur modifiée avec succées');
            if($user->getRoles() == "ROLE_MANAGER"){
                return $this->redirectToRoute('Manager');}
            else{
                return $this->redirectToRoute('Client');
            }
        }
        return $this->render('Manager/edit.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("{id}/delete-user", name="user-delete")
     * @Method("POST")
     */
    public function deleteUserAction(Request $request, User $user){
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token')))
        {
            return $this->redirectToRoute('all-users');
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        $this->addFlash('success', 'Utilisateur supprimé avec succés');
        return $this->redirectToRoute('Manager');
    }
}