<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Listing
 *
 * @ORM\Table(name="listing")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ListingRepository")
 */
class Listing
{

    const NOT_FOUND = "Listing Not Found.";
    const DELETED_SUCCESS = "Listing Deleted Successfully";

   /**
    * @ORM\ManyToOne(targetEntity="User", inversedBy="listings")
    * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
    */
    private $user;

   /**
    * @ORM\ManyToOne(targetEntity="Category", inversedBy="listings")
    * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
    */
    private $category;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\File(mimeTypes={ "image/jpeg", "image/png" })
     */
    private $image;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;


    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="size", type="string", length=255)
     */
    private $size;


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
     * Set name
     *
     * @param string $name
     *
     * @return Listing
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Listing
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set size
     *
     * @param string $size
     *
     * @return Listing
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set user
     *
     * @param object $user
     *
     * @return Listing
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get category
     *
     *
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set category
     *
     * @param object $user
     *
     * @return Listing
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Listing
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
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
}
