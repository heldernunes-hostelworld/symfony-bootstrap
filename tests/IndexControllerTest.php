<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IndexControllerTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
       
        $client->request('GET', '/best-route?from=1&to=2');
        $response = $client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $this->assertNotEmpty($client->getResponse()->getContent());
        
    }
}
