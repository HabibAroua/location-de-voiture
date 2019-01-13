<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\Column(name="image",type="string", length=255, nullable=true)
     */
    public $image;

    /**
     * @Assert\File(maxSize="600000000")
     */
    public $file;

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



    /**
     * @return mixed
     */
    public function getImage()
    {
        $image = $this->image;
        if(empty($image))
            $image = "no_avatar.jpg";
        return $image;

    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload() {
        if (null !== $this->file) {
            // do whatever you want to generate a unique name
            $filename = sha1(uniqid(mt_rand(), true));
            $this->image = $filename . '.' . $this->file->guessExtension();
        }
    }
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        // check if we have an old image imagelink
        if (isset($this->image)) {
            // store the old name to delete after the update
            $this->temp = $this->image;
            $this->image = null;
        } else {
            $this->image = 'initial';
        }
    }


    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file)
        {
            return;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->file->move($this->getUploadRootDir(), $this->image);

        unset($this->file);
    }


    public function getAbsoluteimage()
    {
        return null === $this->image ? null : $this->getUploadRootDir().'/'.$this->image;
    }

    public function getWebimage()
    {
        return null === $this->image ? null : $this->getUploadDir().'/'.$this->id.'/'.$this->image;
    }

    public function getUploadRootDir()
    {
        // the absolute directory imagelink where uploaded documents should be saved
        return __DIR__.'/../../../web/'.$this->getUploadDir().'/'.$this->id;
    }

    public function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
        return 'uploads/images';
    }






    }

