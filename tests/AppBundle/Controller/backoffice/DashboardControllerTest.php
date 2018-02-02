<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DashboardControllerTest extends WebTestCase
{
    public function testSecurityRedirect()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'admin/listings');

        $this->assertRegExp('/\/login$/', $client->getResponse()->headers->get('location'));

//        $this->assertContains('Add Listing', $crawler->filter('body > div.wrapper > div.main-panel > div > div.content > div > a > button')->text());
    }

    public function testAdminLogin()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin@mail.com',
            'PHP_AUTH_PW'   => 'abc',
        ));

        $crawler = $client->request('GET', 'admin/listings');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testUserRoleDenied()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'a@b.c',
            'PHP_AUTH_PW' => 'abc'
        ));

        $crawler = $client->request('GET', 'admin/listings');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }

}
