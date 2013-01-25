<?php

namespace Caesar\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Caesar\UserBundle\Entity\UserRepository")
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="UNCodeBU", columns={"codeBu"}),
 *  @ORM\UniqueConstraint(name="UNLogin", columns={"login"})})
 */
class User {

    /**
     * @var integer $id
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var int $codeBu
     * 
     * @ORM\Column(name="codeBu", type="integer",length=10)
     */
    private $codeBu;
    
    /**
     * @var string $login
     * 
     * @ORM\Column(name="login", type="string", length=100)
     */
    private $login;

    /**
     * @var string $motDePasse
     * 
     * @ORM\Column(name="motDePasse", type="string", length=100)
     */
    private $motDePasse;

    /**
     * @var string $email
     * 
     * @ORM\Column(name="email", type="string", length=100)
     */
    private $email;

    /**
     * @var string $nom
     * 
     * @ORM\Column(name="name", type="string", length=60)
     */
    private $nom;

    /**
     * @var string $prenom
     * 
     * @ORM\Column(name="prenom", type="string", length=50)
     */
    private $prenom;

    /**
     * @var string $role
     * 
     * @ORM\Column(name="role", type="string", length=50)
     */
    private $role;

    public function getId() {
        return $this->id;
    }

    public function getLogin() {
        return $this->login;
    }

    public function setLogin($login) {
        $this->login = $login;
        return $this;
    }

    public function getMotDePasse() {
        return $this->motDePasse;
    }

    public function setMotDePasse($motDePasse) {
        $this->motDePasse = $motDePasse;
        return $this;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
        return $this;
    }

    public function getRole() {
        return $this->role;
    }

    public function setRole($role) {
        $this->role = $role;
        return $this;
    }


    /**
     * Set codeBu
     *
     * @param integer $codeBu
     * @return User
     */
    public function setCodeBu($codeBu)
    {
        $this->codeBu = $codeBu;
    
        return $this;
    }

    /**
     * Get codeBu
     *
     * @return integer 
     */
    public function getCodeBu()
    {
        return $this->codeBu;
    }
}