<?php

namespace Caesar\ResourceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="Caesar\ResourceBundle\Entity\ResourceRepository")
 * @ORM\Table(name="resource")
 * @UniqueEntity("nom")
 */
class Resource {

    /**
     * @var integer $id
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Caesar\ShelfBundle\Entity\Shelf", inversedBy="resources")
     * @ORM\JoinColumn(name="shelf_id", referencedColumnName="id")
     * */
    private $shelf;

    /**
     * @ORM\OneToOne(targetEntity="Caesar\TagBundle\Entity\Tag", mappedBy="resource")
     * */
    private $tag;

    /**
     * @var int $code
     * 
     * @ORM\Column(name="code", type="bigint", unique=true)
     */
    private $code;

    /**
     * @var int $description
     * 
     * @ORM\Column(name="description", type="string",length=255)
     */
    private $description;

    /**
     * @var int $longDescription
     * 
     * @ORM\Column(name="longDescription", type="text")
     */
    private $longDescription;

    /**
     * @var int $quantity
     * 
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;
    
     /**
     * @var string $image
     * 
     * @ORM\Column(name="image", type="string",length=255)
     */
    private $image;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set shelf
     *
     * @param \Caesar\ShelfBundle\Entity\Shelf $shelf
     * @return Resource
     */
    public function setShelf(\Caesar\ShelfBundle\Entity\Shelf $shelf = null) {
        $this->shelf = $shelf;

        return $this;
    }

    /**
     * Get shelf
     *
     * @return \Caesar\ShelfBundle\Entity\Shelf 
     */
    public function getShelf() {
        return $this->shelf;
    }

    /**
     * Set code
     *
     * @param integer $code
     * @return Resource
     */
    public function setCode($code) {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return integer 
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Resource
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set longDescription
     *
     * @param string $longDescription
     * @return Resource
     */
    public function setLongDescription($longDescription) {
        $this->longDescription = $longDescription;

        return $this;
    }

    /**
     * Get longDescription
     *
     * @return string 
     */
    public function getLongDescription() {
        return $this->longDescription;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return Resource
     */
    public function setQuantity($quantity) {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity() {
        return $this->quantity;
    }

    /**
     * Set tag
     *
     * @param \Caesar\TagBundle\Entity\Tag $tag
     * @return Resource
     */
    public function setTag(\Caesar\TagBundle\Entity\Tag $tag = null) {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return \Caesar\TagBundle\Entity\Tag 
     */
    public function getTag() {
        return $this->tag;
    }


    /**
     * Set image
     *
     * @param string $image
     * @return Resource
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
}