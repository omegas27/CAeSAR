<?php
namespace CAeSAR\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CAeSAR\UserBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
    	$arrResult = array();
    	$arrLines = file('src/Caesar/UserBundle/DataFixtures/ORM/userFixtures.csv');
    	foreach($arrLines as $line) {
    		$arrResult[] = explode( ',', $line);
    	}
    	foreach($arrResult as $res) {
    		$userAdmin = new User();
    		$userAdmin->setCodeBu($res[0]);
    		$userAdmin->setName($res[4]);
    		$userAdmin->setFirstname($res[5]);
    		$userAdmin->setEmail($res[3]);
    		$userAdmin->setUsername($res[1]);
    		$userAdmin->setPassword($res[2]);
    		$userAdmin->setRole('ROLE_USER');    		
    		$manager->persist($userAdmin);
    	}        
        
        $manager->flush();        
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
}