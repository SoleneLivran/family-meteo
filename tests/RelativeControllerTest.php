<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\UserRepository;

class RelativeControllerTest extends WebTestCase
{
    // check if user can access a relative's details when connected
    public function testRelativeViewAccessWhileLoggedIn()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByUsername('testuser');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $client->request('GET', '/relatives/1');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h4', 'Eddard Stark');
    }

    // check if user if redirected to /login if trying to access a relative's details when not connected
    public function testRelativeViewRedirectToLogin()
    {
        $client = self::createClient();
        $client->request('GET', '/relatives/1');

        $this->assertSame('/login', $client->getResponse()->headers->get('Location'));
    }
}