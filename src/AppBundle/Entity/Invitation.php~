<?php
//src/AppBundle/Entity/Invitation.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity 
 * @ORM\Table(name="invitation")
 */
class Invitation {

    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=6)
     */
    protected $code;

    /**
     * @ORM\Column(type="string", length=256)
     */
    protected $email;

    /**
     * When sending invitation be sure to set this value to 'true'
     * 
     * It can prevent invitations form being sent twice
     * 
     * @ORM\Column(type="boolean")
     */
    protected $sent = false;

    public function __construct() {
        //generate identifier only once, here a 6 character length code
        $this->code = substr(md5(uniqid(rand(), true)), 0, 6);
    }

    public function getCode() {
        return $this->code;
    }

    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    public function getEmail() {
        return $this->email;
    }

    public function send() {
        $this->sent = true;

        return $this;
    }

    public function isSent() {
        return $this->sent;
    }


    /**
     * Set code
     *
     * @param string $code
     * @return Invitation
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Set sent
     *
     * @param boolean $sent
     * @return Invitation
     */
    public function setSent($sent)
    {
        $this->sent = $sent;

        return $this;
    }

    /**
     * Get sent
     *
     * @return boolean 
     */
    public function getSent()
    {
        return $this->sent;
    }
}
