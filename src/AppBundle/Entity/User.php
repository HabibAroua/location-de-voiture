<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as FosUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="fos_user")
 */
class User extends FosUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable = true)
     * @Assert\Length(
     *     min=0,
     *     max=8,
     *     minMessage="The phone number is too short.",
     *     maxMessage="The phone number is too long.",
     *
     * )
     */
    private $phoneNumber;


    /**
     * @ORM\Column(name="image",type="string", length=255, nullable=true)
     */
    public $image;

    /**
     * @Assert\File(maxSize="600000000")
     */
    public $file;


    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="user")
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="users")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="Location", mappedBy="user")
     */
    private $locations;

    /**
     * @ORM\OneToMany(targetEntity="Voiture", mappedBy="user")
     */
    private $voitures;

    /**
     * @var string
     *
     * @ORM\Column(name="fb_id", type="string", length=225, nullable=true)
     */
    private $fb_id;

    /**
     * @return string
     */
    public function getFbId()
    {
        return $this->fb_id;
    }

    /**
     * @param string $fb_id
     */
    public function setFbId($fb_id)
    {
        $this->fb_id = $fb_id;
    }

    /**
     * @var datetime $created_at
     * @ORM\Column(type="datetime")
     */
    protected $created_at;

    /**
     * @var datetime $updated_at
     * @ORM\Column(type="datetime", nullable = true)
     */
    protected $updated_at;


    public function __construct()
    {
        parent::__construct();
        $this->users = new ArrayCollection();
        $this->locations = new ArrayCollection();
        $this->voitures = new ArrayCollection();
        $this->created_at= new \DateTime();
        $this->updated_at= new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param mixed $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }


    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

   /**
     * Gets triggered only on insert

     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->created_at = new \DateTime("now");
    }

    /**
     * Gets triggered every time on update

     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {

        $this->updated_at = new \DateTime("now");
    }

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param mixed $users
     */
    public function setUsers(ArrayCollection $users)
    {
        $this->users = $users;
    }

    /**
     * @return datetime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param datetime $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return mixed
     */
    public function getVoitures()
    {
        return $this->voitures;
    }

    /**
     * @param mixed $voitures
     */
    public function setVoitures($voitures)
    {
        $this->voitures = $voitures;
    }





    /**
     * @return datetime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param datetime $updated_at
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
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

    /**
     * Add user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return User
     */
    public function addUser(\AppBundle\Entity\User $user)
    {
        $this->users[] = $user;
    
        return $this;
    }

    /**
     * Remove user
     *
     * @param \AppBundle\Entity\User $user
     */
    public function removeUser(\AppBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

}
