<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function provideUrls()
    {
        return [
            ['/login'],
            ['/register'],
        ];
    }

    /**
     * @dataProvider provideUrls
     * @param $url
     */
    public function testPageIsSuccessful($url)
    {
        $client = static::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    // test if redirected to homepage if already connected

    /**
     * @dataProvider provideUrls
     * @param $url
     */
    public function testRedirectIfConnected($url)
    {
        $client = static::createClient();

        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByUsername('testuser');
        $client->loginUser($testUser);

        $client->followRedirects();
        $client->request('GET', $url);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Testuser');
    }
}