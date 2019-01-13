<?php
namespace AppBundle\Controller;
use AppBundle\Entity\Voiture;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Form\VoitureType;

/**
 * Class VoituresController
 * @package AppBundle\Controller
 */
class VoituresController extends Controller
{
    /**
     * List all cars
     *
     * @Route("/voitures", name="Voiture")
     */
    public function index()
    {
        $voitures = $this->getDoctrine()
                ->getRepository(Voiture::class)
                ->findAll();
            return $this->render('Voitures/index.html.twig', array(
                'voitures' => $voitures,
            ));
    }


    /**
     * Create new car
     *
     * @Route("/create-car", name="car-create")
     * @Method({"GET", "POST"})
     */
    public function createCarAction(Request $request){

        $voiture = new Voiture();
        $voiture->setUser($this->getUser());
        //$user->setRoles($this->getUser()->getRoles());
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                //$user = $form->getData();
                $em = $this->getDoctrine()->getManager();
                $em->persist($voiture);
                $em->flush();
                $this->addFlash('success', 'voiture enregistrer avec succées');
                    return $this->redirectToRoute('Voiture');
            }

        return $this->render('Voitures/create.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    /**
     * @Route("{id}/edit-car", requirements={"id": "\d+"}, name="car-edit")
     * @Method({"GET", "POST"})
     */
    public function editVoitureAction(Request $request, Voiture $voiture){

        $voiture->setUser($this->getUser());
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($voiture);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'Voiture modifié avec succées');
            return $this->redirectToRoute('Voiture');
        }
        return $this->render('Voitures/edit.html.twig', array(
            'voiture' => $voiture,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("{id}/delete-car", name="car-delete")
     * @Method("POST")
     */
    public function deleteCarAction(Request $request, Voiture $voiture){
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('Voiture');
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($voiture);
        $em->flush();
        $this->addFlash('success', 'Voiture supprimé avec succés');
        return $this->redirectToRoute('Voiture');
    }





}