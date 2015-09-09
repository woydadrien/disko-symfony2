<?php

/**
 * Entity
 *
 * @author Adrien Jerphagnon <adrien.j@disko.fr>
 */

namespace Disko\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class User
 *
 * @ORM\Entity(repositoryClass="Disko\UserBundle\Repository\UserRepository")
 * @ORM\Table(name="by_user")
 */
class User extends BaseUser
{
    /**
     * Id
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Slug
     *
     * @Gedmo\Slug(fields={"username"})
     * @ORM\Column(length=255, unique=true)
     */
    protected $slug;

    /**
     * Civility
     *
     * @ORM\Column(length=255)
     */
    protected $civility = 'm';

    /**
     * Firstname
     *
     * @ORM\Column(length=255)
     */
    protected $firstName;

    /**
     * Lastname
     *
     * @ORM\Column(length=255)
     */
    protected $lastName;

    /**
     * Edit
     *
     * @var datetime $updated
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $birthday;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $news = false;

    /**
     * @ORM\OneToMany(targetEntity="Localisation", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $localisations;

    /**
     * Creation
     *
     * @var datetime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * Edit
     *
     * @var datetime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    protected $updated;

    /**
     * Set created
     * @param \Disko\UserBundle\Entity\datetime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * Get created
     *
     * @return \Disko\UserBundle\Entity\datetime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set id
     *
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get id
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set slug
     *
     * @param mixed $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Get Slug
     *
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set updated
     *
     * @param \Disko\UserBundle\Entity\datetime $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * Get updated
     *
     * @return \Disko\UserBundle\Entity\datetime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set firstname
     *
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * Get firstname
     *
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastname
     *
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * Get lastname
     *
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set mail
     * @param  string     $email
     * @return $this|void
     */
    public function setEmail($email)
    {
        parent::setEmail($email);
        $this->setUsername($email);
    }

    /**
     * @param \Disko\UserBundle\Entity\datetime $birthday
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }

    /**
     * @return \Disko\UserBundle\Entity\datetime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @param mixed $civility
     */
    public function setCivility($civility)
    {
        $this->civility = $civility;
    }

    /**
     * @return mixed
     */
    public function getCivility()
    {
        return $this->civility;
    }

    /**
     * @param mixed $news
     */
    public function setNews($news)
    {
        $this->news = $news;
    }

    /**
     * @return mixed
     */
    public function getNews()
    {
        return $this->news;
    }

    /**
     * Set localisations
     *
     * @param array $localisations
     *
     * @return User
     */
    public function setLocalisations($localisations)
    {
        $this->localisations[] = $localisations;

        return $this;
    }

    /**
     * Add localisations
     *
     * @param  \Disko\UserBundle\Entity\Localisation $localisations
     * @return User
     */
    public function addLocalisation(\Disko\UserBundle\Entity\Localisation $localisations)
    {
        $this->localisations[] = $localisations;

        $localisations->setUser($this);

        return $this;
    }

    /**
     * Remove localisations
     *
     * @param \Disko\UserBundle\Entity\Localisation $localisations
     */
    public function removeLocalisation(\Disko\UserBundle\Entity\Localisation $localisations)
    {
        $this->localisations->removeElement($localisations);
    }

    /**
     * Get localisations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLocalisations()
    {
        return $this->localisations;
    }
}
