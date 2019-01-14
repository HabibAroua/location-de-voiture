<?php
namespace AppBundle\Controller;
use AppBundle\Entity\Caracteristique;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Form\CaracteristiqueType;

/**
 * Class CaracteristiquesController
 * @package AppBundle\Controller
 */
class CaracteristiquesController extends Controller
{
    /**
     * List all caracteristiques
     *
     * @Route("/caracteristiques", name="caracteristiques")
     */
    public function index()
    {
        $caracteristiques = $this->getDoctrine()
            ->getRepository(Caracteristique::class)
            ->findAll();
        return $this->render('Caracteristique/index.html.twig', array(
            'caracteristiques' => $caracteristiques,
        ));
    }


    /**
     * Create new caracteristique
     *
     * @Route("/create-caracteristique", name="create-caracteristique")
     * @Method({"GET", "POST"})
     */
    public function createCaracteristiqueAction(Request $request){

        $caracteristique = new Caracteristique();
        $form = $this->createForm(CaracteristiqueType::class, $caracteristique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$user = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($caracteristique);
            $em->flush();
            $this->addFlash('success', 'caracteristique enregistrer avec succées');
            return $this->redirectToRoute('caracteristiques');
        }

        return $this->render('Caracteristique/create.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    /**
     * @Route("{id}/edit-caracteristique", requirements={"id": "\d+"}, name="edit-caracteristique")
     * @Method({"GET", "POST"})
     */
    public function editVoitureAction(Request $request, Caracteristique $caracteristique){

        $caracteristique->setVoiture($caracteristique->getVoiture());
        $form = $this->createForm(CaracteristiqueType::class, $caracteristique);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($caracteristique);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'Caracteristique modifié avec succées');
            return $this->redirectToRoute('caracteristiques');
        }
        return $this->render('Caracteristique/edit.html.twig', array(
            'caracteristique' => $caracteristique,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("{id}/caracteristique", name="caracteristique-delete")
     * @Method("POST")
     */
    public function deleteCarAction(Request $request, Caracteristique $caracteristique){
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('caracteristiques');
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($caracteristique);
        $em->flush();
        $this->addFlash('success', 'Caracteristique supprimé avec succés');
        return $this->redirectToRoute('caracteristiques');
    }





}