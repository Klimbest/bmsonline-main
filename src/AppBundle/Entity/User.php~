<?php
//src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="system_user")
 */
class User extends BaseUser {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \Doctrine\Common\Collection\ArrayCollection
     * @ORM\ManyToMany(targetEntity="Target", mappedBy="users")
     */
    private $targets;
    
    /**
     * @ORM\OneToOne(targetEntity="Invitation")
     * @ORM\JoinColumn(referencedColumnName="code")
     * @Assert\NotNull(message="Twój kod zaproszenia jest nieprawidłowy", groups={"Registration"})
     */
    protected $invitation;
    
    /**
     *
     * @var type integer
     * @ORM\Column(name="failed_login", type="integer", nullable=true)
     * 
     */
    protected $failedLogin;
    
    /**
     *
     * @var type string
     * @ORM\Column(name="failed_login_ip", type="string", nullable=true)
     * 
     */
    protected $failedLoginIp;
    
    public function __construct() {
        parent::__construct();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add targets
     *
     * @param \AppBundle\Entity\Target $targets
     * @return User
     */
    public function addTarget(\AppBundle\Entity\Target $targets)
    {
        $this->targets[] = $targets;

        return $this;
    }

    /**
     * Remove targets
     *
     * @param \AppBundle\Entity\Target $targets
     */
    public function removeTarget(\AppBundle\Entity\Target $targets)
    {
        $this->targets->removeElement($targets);
    }

    /**
     * Get targets
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTargets()
    {
        return $this->targets;
    }

    /**
     * Set invitation
     *
     * @param \AppBundle\Entity\Invitation $invitation
     * @return User
     */
    public function setInvitation(\AppBundle\Entity\Invitation $invitation = null)
    {
        $this->invitation = $invitation;

        return $this;
    }

    /**
     * Get invitation
     *
     * @return \AppBundle\Entity\Invitation 
     */
    public function getInvitation()
    {
        return $this->invitation;
    }
    
    public function setEmail($email) {
        $email = is_null($email) ? '' : $email;
        parent::setEmail($email);
        $this->setUsername($email);
        
        return $this;
    }

    /**
     * Set failedLogin
     *
     * @param integer $failedLogin
     * @return User
     */
    public function setFailedLogin($failedLogin)
    {
        $this->failedLogin = $failedLogin;

        return $this;
    }

    /**
     * Get failedLogin
     *
     * @return integer 
     */
    public function getFailedLogin()
    {
        return $this->failedLogin;
    }

    /**
     * Set failedLoginIp
     *
     * @param string $failedLoginIp
     * @return User
     */
    public function setFailedLoginIp($failedLoginIp)
    {
        $this->failedLoginIp = $failedLoginIp;

        return $this;
    }

    /**
     * Get failedLoginIp
     *
     * @return string 
     */
    public function getFailedLoginIp()
    {
        return $this->failedLoginIp;
    }
}
