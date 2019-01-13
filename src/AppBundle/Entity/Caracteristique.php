<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Caracteristique
 *
 * @ORM\Table(name="caracteristique")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CaracteristiqueRepository")
 */
class Caracteristique
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
    private  $couleur;

     /**
     * @ORM\Column(type="string",nullable =true)
     */
    private  $nbrChevaux;

    /**
     * @ORM\ManyToOne(targetEntity="Voiture", inversedBy="caracteristiques")
     * @ORM\JoinColumn(name="voiture_id", referencedColumnName="id")
     */
    private $voiture;

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
    public function getCouleur()
    {
        return $this->couleur;
    }

    /**
     * @param mixed $couleur
     */
    public function setCouleur($couleur)
    {
        $this->couleur = $couleur;
    }

    /**
     * @return mixed
     */
    public function getNbrChevaux()
    {
        return $this->nbrChevaux;
    }

    /**
     * @param mixed $nbrChevaux
     */
    public function setNbrChevaux($nbrChevaux)
    {
        $this->nbrChevaux = $nbrChevaux;
    }

    /**
     * @return mixed
     */
    public function getVoiture()
    {
        return $this->voiture;
    }

    /**
     * @param mixed $voiture
     */
    public function setVoiture($voiture)
    {
        $this->voiture = $voiture;
    }




}

