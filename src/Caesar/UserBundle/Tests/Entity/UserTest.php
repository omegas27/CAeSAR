<?php
namespace Caesar\UserBundle\Tests\Entity;

use Caesar\UserBundle\Entity\User;

class UserTest extends \PHPUnit_Framework_TestCase
{
	public function testUsername() {
		$user = new User();
		$user->setUsername("john");
		$data = $user->getUsername();
				
		$this->assertEquals("john", $data);
	}
	
	public function testCodeBu() {
		$user = new User();
		$user->setCodeBu(12);
		$data = $user->getCodeBu();
	
		$this->assertEquals(12, $data);
	}
	
	public function testEmail() {
		$user = new User();
		/*$user->setEmail(22);
		$data = $user->getEmail();
	
		$this->assertNotEquals(22, $data);*/
		
		$user->setEmail("mail");
		$data = $user->getEmail();
		
		$this->assertEquals("mail", $data);
	}
	
	public function testConfirmMotDePasse() {
		$user = new User();
		$user->setConfirmMotDePasse("john");
		$data = $user->getConfirmMotDePasse();
	
		$this->assertEquals("john", $data);
	}
	
	public function testMotDePasse() {
		$user = new User();
		$user->setMotDePasse("john");
		$data = $user->getMotDePasse();
	
		$this->assertEquals("john", $data);
	}
	
	public function testNom() {
		$user = new User();
		$user->setNom("john");
		$data = $user->getNom();
	
		$this->assertEquals("john", $data);
	}
	
	
	
	
}