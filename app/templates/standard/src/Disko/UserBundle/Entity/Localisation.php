<?php

namespace Disko\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Disko\UserBundle\Repository\LocalisationRepository")
 * @ORM\Table(name="by_localisation")
 */
class Localisation
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(length=255, nullable=true)
     */
    protected $title;

    /**
     * @ORM\Column(length=255, nullable=true)
     */
    protected $address;

    /**
     * @ORM\Column(length=255, nullable=true)
     */
    protected $addressMore;

    /**
     * @ORM\Column(length=255, nullable=true)
     */
    protected $code;

    /**
     * @ORM\Column(length=255, nullable=true)
     */
    protected $city;

    /**
     * @ORM\Column(length=255, nullable=true)
     */
    protected $country;

    /**
     * @ORM\Column(length=255, nullable=true)
     */
    protected $phone;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="localisations", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="cascade")
     * @var User
     */
    protected $user;

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
     * Set address
     *
     * @param  string       $address
     * @return Localisation
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set addressMore
     *
     * @param  string       $addressMore
     * @return Localisation
     */
    public function setAddressMore($addressMore)
    {
        $this->addressMore = $addressMore;

        return $this;
    }

    /**
     * Get addressMore
     *
     * @return string
     */
    public function getAddressMore()
    {
        return $this->addressMore;
    }

    /**
     * Set code
     *
     * @param  string       $code
     * @return Localisation
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set city
     *
     * @param  string       $city
     * @return Localisation
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set phone
     *
     * @param  string       $phone
     * @return Localisation
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set user
     *
     * @param  \Disko\UserBundle\Entity\User $user
     * @return Localisation
     */
    public function setUser(\Disko\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Disko\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }
}
