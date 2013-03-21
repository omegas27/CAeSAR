<?php

namespace Caesar\ResourceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="Caesar\ResourceBundle\Entity\ResourceRepository")
 * @ORM\Table(name="resource")
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
   * @Assert\NotBlank()
   * */
  private $shelf;

  /**
   * @var int $code
   *
   * @ORM\Column(name="code", type="string",length=20, unique=true)
   * @Assert\NotBlank()
   */
  private $code;

  /**
   * @var int $description
   *
   * @ORM\Column(name="description", type="string",length=255)
   * @Assert\NotBlank()
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
   * @Assert\NotBlank()
   * @Assert\Min(limit = "1", message = "La valeur doit être supérieur à 1.")
   * @Assert\Type(type="integer", message="La valeur {{ value }} n'est pas un type {{ type }} valide."))
   */
  private $quantity;

  /**
   * @var string $path
   *
   * @ORM\Column(name="path", type="string",length=255)
   * @Assert\NotBlank()
   */
  private $path;

  /**
   * @var string $local
   * @Assert\Image(
   *  mimeTypes = {"image/jpeg","image/png"}
   * )
   *
   */
  private $local;

  /**
   * @var string $url
   * @Assert\Url()
   * @Assert\Regex("/^https?:\/\/(?:[a-z\-]+\.)+[a-z]{2,6}(?:\/[^\/#?]+)+\.(?:jpe?g|png)$/")
   */
  private $url;

  /**
   * @ORM\OneToMany(targetEntity="Caesar\UserBundle\Entity\Borrowing", mappedBy="resource")
   */
  private $borrowings;

  /**
   * @ORM\OneToMany(targetEntity="Caesar\UserBundle\Entity\BorrowingArchive", mappedBy="resource")
   */
  private $borrowingArchives;

  /**
   * @ORM\OneToMany(targetEntity="Caesar\UserBundle\Entity\Reservation", mappedBy="resource")
   * @ORM\OrderBy({"reservationDate" = "ASC"})
   */
  private $reservations;

  function __construct() {
    $this->borrowings = new ArrayCollection();
    $this->borrowingArchives = new ArrayCollection();
    $this->reservation = new ArrayCollection();
  }

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
  public function setPath($path) {
    $this->path = $path;

    return $this;
  }

  /**
   * Get image
   *
   * @return string
   */
  public function getPath() {
    return $this->path;
  }

  public function getLocal() {
    return $this->local;
  }

  public function setLocal($local) {
    $this->local = $local;
  }

  public function getUrl() {
    return $this->url;
  }

  public function setUrl($url) {
    $this->url = $url;
  }

  /**
   * Add borrowings
   *
   * @param \Caesar\UserBundle\Borrowing $borrowings
   * @return Resource
   */
  public function addBorrowing(\Caesar\UserBundle\Entity\Borrowing $borrowings) {
    $this->borrowings[] = $borrowings;

    return $this;
  }

  /**
   * Remove borrowings
   *
   * @param \Caesar\UserBundle\Borrowing $borrowings
   */
  public function removeBorrowing(\Caesar\UserBundle\Entity\Borrowing $borrowings) {
    $this->borrowings->removeElement($borrowings);
  }

  /**
   * Get borrowings
   *
   * @return \Doctrine\Common\Collections\Collection
   */
  public function getBorrowings() {
    return $this->borrowings;
  }

  /**
   * Add borrowingArchives
   *
   * @param \Caesar\UserBundle\Entity\BorrowingArchive $borrowingArchives
   * @return Resource
   */
  public function addBorrowingArchive(\Caesar\UserBundle\Entity\BorrowingArchive $borrowingArchives) {
    $this->borrowingArchives[] = $borrowingArchives;

    return $this;
  }

  /**
   * Remove borrowingArchives
   *
   * @param \Caesar\UserBundle\Entity\BorrowingArchive $borrowingArchives
   */
  public function removeBorrowingArchive(\Caesar\UserBundle\Entity\BorrowingArchive $borrowingArchives) {
    $this->borrowingArchives->removeElement($borrowingArchives);
  }

  /**
   * Get borrowingArchives
   *
   * @return \Doctrine\Common\Collections\Collection
   */
  public function getBorrowingArchives() {
    return $this->borrowingArchives;
  }

  /**
   * Add reservations
   *
   * @param \Caesar\UserBundle\Entity\Reservation $reservations
   * @return Resource
   */
  public function addReservation(\Caesar\UserBundle\Entity\Reservation $reservations) {
    $this->reservations[] = $reservations;

    return $this;
  }

  /**
   * Remove reservations
   *
   * @param \Caesar\UserBundle\Entity\Reservation $reservations
   */
  public function removeReservation(\Caesar\UserBundle\Entity\Reservation $reservations) {
    $this->reservations->removeElement($reservations);
  }

  /**
   * Get reservations
   *
   * @return \Doctrine\Common\Collections\Collection
   */
  public function getReservations() {
    return $this->reservations;
  }

  public function getJsonData() {
    return get_object_vars($this);
  }

  /**
   * ISBN
   */

  public static function isCAeSARCode($code) {
    return preg_match("/^C-[0-9]*$/", $code);
  }


  /**
   * Cette fonction teste si une chaîne est un ISBN-10 ou un ISBN-13
   * @param type $isbn
   * @return boolean
   */
  public static function checkISBN($isbn) {
    $type = Resource::getISBNtype($isbn);
    if ($type === -1) {
      return false;
    } else if ($type === 13) {
      return Resource::validatettn($isbn) > 0;
    } else {
      return Resource::validateten($isbn) > 0;
    }
  }

  /**
   * Cette fonction permet de savoir si une chaîne est un ISBN-10 ou un ISBN-13
   * @param type $isbn
   * @return int
   */
  private static function getISBNtype($isbn) {
    if (preg_match('%[0-9]{12}?[0-9Xx]%s', $isbn)) {
      return 13;
    } else if (preg_match('%[0-9]{9}?[0-9Xx]%s', $isbn)) {
      return 10;
    } else {
      return -1;
    }
  }

  /**
   * Cette fonction permet de valider un code ISBN-10
   *
   * @param type $isbn
   * @return int
   */
  private static function validateten($isbn) {
    $chksum = substr($isbn, -1, 1);
    $isbn = substr($isbn, 0, -1);
    if (preg_match('/X/i', $chksum)) {
      $chksum = "10";
    }
    $sum = Resource::genchksum10($isbn);
    if ($chksum == $sum) {
      return 1;
    } else {
      return 0;
    }
  }

  /**
   * Cette fonction permet de valider un code ISBN-13
   *
   * @param type $isbn
   * @return int
   */
  private static function validatettn($isbn) {
    $chksum = substr($isbn, -1, 1);
    $isbn = substr($isbn, 0, -1);
    if (preg_match('/X/i', $chksum)) {
      $chksum = "10";
    }
    $sum = Resource::genchksum13($isbn);
    if ($chksum == $sum) {
      return 1;
    } else {
      return 0;
    }
  }

  private static function genchksum13($isbn) {
    $tb = 0;
    for ($i = 0; $i <= 12; $i++) {
      $tc = substr($isbn, -1, 1);
      $isbn = substr($isbn, 0, -1);
      $ta = ($tc * 3);
      $tci = substr($isbn, -1, 1);
      $isbn = substr($isbn, 0, -1);
      $tb = $tb + $ta + $tci;
    }
    $tg = ($tb / 10);
    $tint = intval($tg);
    if ($tint == $tg) {
      return 0;
    }
    $ts = substr($tg, -1, 1);
    $tsum = (10 - $ts);
    return $tsum;
  }

  private static function genchksum10($isbn) {
    $t = 2;
    $isbn = trim($isbn);
    $a = 0;
    $b = 0;
    for ($i = 0; $i <= 9; $i++) {
      $b = $b + $a;
      $c = substr($isbn, -1, 1);
      $isbn = substr($isbn, 0, -1);
      $a = ($c * $t);
      $t++;
    }
    $s = ($b / 11);
    $s = intval($s);
    $s++;
    $g = ($s * 11);
    $sum = ($g - $b);
    return $sum;
  }

}