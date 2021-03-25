<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\UserRepository;

class HomeTest extends WebTestCase
{
    // check if user can access homes list when connected
    public function testHomepageAccessWhileLoggedIn()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByUsername('testuser');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        // test e.g. the profile page
        $client->request('GET', '/homes');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Liste des foyers');
    }

    // check if user if redirected to /login if trying to access homes list page when not connected
    public function testHomepageRedirectToLogin()
    {
        $client = self::createClient();
        $client->request('GET', '/homes');

        $this->assertSame('/login', $client->getResponse()->headers->get('Location'));
    }
}