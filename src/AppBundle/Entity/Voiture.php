<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Voiture
 *
 * @ORM\Table(name="voiture")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VoitureRepository")
 */
class Voiture
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

     /**
     * @ORM\Column(type="string",nullable =true)
     */
    private  $matricule;

    /**
     * @ORM\Column(type="string",nullable =true)
     */
    private  $modele;

    /**
     * @ORM\Column(type="string",nullable =true)
     */
    private  $constructeur;

    /**
     * @ORM\Column(type="string",nullable =true)
     */
    private  $moteur;

    /**
     * @ORM\OneToMany(targetEntity="Caracteristique", mappedBy="voiture")
     */
    private $caracteristiques;

    /**
     * @ORM\OneToMany(targetEntity="Location", mappedBy="voiture")
     */
      private $locations;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="voitures")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;


    public function __construct(){
        $this->locations = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getMatricule()
    {
        return $this->matricule;
    }

    /**
     * @param mixed $matricule
     */
    public function setMatricule($matricule)
    {
        $this->matricule = $matricule;
    }

    /**
     * @return mixed
     */
    public function getModele()
    {
        return $this->modele;
    }

    /**
     * @param mixed $modele
     */
    public function setModele($modele)
    {
        $this->modele = $modele;
    }

    /**
     * @return mixed
     */
    public function getConstructeur()
    {
        return $this->constructeur;
    }

    /**
     * @param mixed $constructeur
     */
    public function setConstructeur($constructeur)
    {
        $this->constructeur = $constructeur;
    }

    /**
     * @return mixed
     */
    public function getMoteur()
    {
        return $this->moteur;
    }

    /**
     * @param mixed $moteur
     */
    public function setMoteur($moteur)
    {
        $this->moteur = $moteur;
    }

    /**
     * @return mixed
     */
    public function getCaracteristiques()
    {
        return $this->caracteristiques;
    }

    /**
     * @param mixed $caracteristiques
     */
    public function setCaracteristiques($caracteristiques)
    {
        $this->caracteristiques = $caracteristiques;
    }

    /**
     * @return mixed
     */
    public function getLocations()
    {
        return $this->locations;
    }

    /**
     * @param mixed $locations
     */
    public function setLocations($locations)
    {
        $this->locations = $locations;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }






    }

