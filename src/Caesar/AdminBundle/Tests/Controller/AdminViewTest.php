<?php

namespace Caesar\AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase {

    public function testIndex() {
        $client = static::createClient(); 
        $crawler = $client->request('GET', '/fr/admin/login');

        $form = $crawler->selectButton("Connexion")->form();
        $form['_username'] = 'admin';
        $form['_password'] = 'adminadmin';

        $client->submit($form);
        
        $crawler = $client->request('GET', '/fr/admin/');


        $this->assertTrue($crawler->filter('html:contains("administration")')->count() > 0);
    }

}
