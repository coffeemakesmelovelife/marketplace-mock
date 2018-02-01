<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * View
 *
 * @ORM\Table(name="view")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ViewRepository")
 */
class View
{

   /**
    * @ORM\ManyToOne(targetEntity="User", inversedBy="views")
    * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
    */
    private $user;

   /**
    * @ORM\ManyToOne(targetEntity="Listing", inversedBy="views")
    * @ORM\JoinColumn(name="listing_id", referencedColumnName="id")
    */
    private $listing;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


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
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return View
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set listing
     *
     * @param \AppBundle\Entity\Listing $listing
     *
     * @return View
     */
    public function setListing(\AppBundle\Entity\Listing $listing = null)
    {
        $this->listing = $listing;

        return $this;
    }

    /**
     * Get listing
     *
     * @return \AppBundle\Entity\Listing
     */
    public function getListing()
    {
        return $this->listing;
    }
}
