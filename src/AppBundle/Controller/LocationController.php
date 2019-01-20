<?php
namespace AppBundle\Controller;
use AppBundle\Entity\Location;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Form\LocationType;

/**
 * Class LocationController
 * @package AppBundle\Controller
 */
class LocationController extends Controller
{
    /**
     * List all locations
     *
     * @Route("/locations", name="Locations")
     */
    public function index()
    {
        $locations = $this->getDoctrine()
            ->getRepository(Location::class)
            ->findAll();
        return $this->render('Location/index.html.twig', array(
            'locations' => $locations,
        ));
    }


    /**
     * Create new location
     *
     * @Route("/create-location", name="location-create")
     * @Method({"GET", "POST"})
     */
    public function createLocationAction(Request $request){

        $location = new Location();
       // $location->setUser($this->getUser());
        //$user->setRoles($this->getUser()->getRoles());
        $form = $this->createForm(LocationType::class, $location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $beginDate=$request->get("date_debut");
            $endDate=$request->get("date_fin");
            $location->setDateDebut(new \DateTime($beginDate));
            $location->setDateFin(new \DateTime($endDate));
            $em = $this->getDoctrine()->getManager();
            $em->persist($location);
            $em->flush();
            $this->addFlash('success', 'Location enregistrer avec succées');
            return $this->redirectToRoute('Locations');
        }

        return $this->render('Location/create.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    /**
     * @Route("{id}/edit-location", requirements={"id": "\d+"}, name="location-edit")
     * @Method({"GET", "POST"})
     */
    public function editLocationAction(Request $request, Location $location){

        $location->setUser($location->getUser());
        $form = $this->createForm(LocationType::class, $location);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $beginDate=$request->get("date_debut");
            $endDate=$request->get("date_fin");
            $location->setDateDebut(new \DateTime($beginDate));
            $location->setDateFin(new \DateTime($endDate));
            $em = $this->getDoctrine()->getManager();
            $em->persist($location);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'Location modifié avec succées');
            return $this->redirectToRoute('Locations');
        }
        return $this->render('Location/edit.html.twig', array(
            'location' => $location,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("{id}/delete-location", name="location-delete")
     * @Method("POST")
     */
    public function deleteCarAction(Request $request, Location $location){
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('Voiture');
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($location);
        $em->flush();
        $this->addFlash('success', 'Location supprimé avec succés');
        return $this->redirectToRoute('Locations');
    }







}