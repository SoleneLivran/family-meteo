<?php

namespace App\DataFixtures;

use App\Entity\Home;
use App\Entity\Relative;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
         $testUser = new User();
         $testUser->setUsername('testuser');
         $password = $this->encoder->encodePassword($testUser, 'password');
         $testUser->setPassword($password);
         $manager->persist($testUser);
         
         $randomUser = new User();
         $randomUser->setUsername('randomuser');
         $password = $this->encoder->encodePassword($randomUser, 'password');
         $randomUser->setPassword($password);
         $manager->persist($randomUser);

         $tullyHome = new Home();
         $tullyHome->setName('Tully');
         $tullyHome->setCreatedBy($testUser);
         $tullyHome->setIsUserHome(true);
         $tullyHome->setCountry('France');
         $tullyHome->setCityName('Besancon');
         $tullyHome->setPostCode('25000');
         $tullyHome->setLatitude(47.250000);
         $tullyHome->setLongitude(6.033333);
         $manager->persist($tullyHome);

         $starkHome = new Home();
         $starkHome->setName('Stark');
         $starkHome->setCreatedBy($testUser);
         $starkHome->setIsUserHome(false);
         $starkHome->setCountry('France');
         $starkHome->setCityName('Orléans');
         $starkHome->setPostCode('45100');
         $starkHome->setLatitude(47.916667);
         $starkHome->setLongitude(1.900000);
         $manager->persist($starkHome);

         $martellHome = new Home();
         $martellHome->setName('Martell');
         $martellHome->setCreatedBy($testUser);
         $martellHome->setIsUserHome(false);
         $martellHome->setCountry('France');
         $martellHome->setCityName('Nice');
         $martellHome->setPostCode('6100');
         $martellHome->setLatitude(43.700000);
         $martellHome->setLongitude(7.250000);
         $manager->persist($martellHome);

         $baratheonHome = new Home();
         $baratheonHome->setName('Baratheon');
         $baratheonHome->setCreatedBy($randomUser);
         $baratheonHome->setIsUserHome(true);
         $baratheonHome->setCountry('France');
         $baratheonHome->setCityName('Paris');
         $baratheonHome->setPostCode('75000');
         $baratheonHome->setLatitude(48.866667);
         $baratheonHome->setLongitude(2.333333);
         $manager->persist($baratheonHome);

         $lannisterHome = new Home();
         $lannisterHome->setName('Lannister');
         $lannisterHome->setCreatedBy($randomUser);
         $lannisterHome->setIsUserHome(false);
         $lannisterHome->setCountry('France');
         $lannisterHome->setCityName('Toulouse');
         $lannisterHome->setPostCode('31500');
         $lannisterHome->setLatitude(43.600000);
         $lannisterHome->setLongitude(1.433333);
         $manager->persist($lannisterHome);

         $nedStark = new Relative();
         $nedStark->setFirstname('Eddard');
         $nedStark->setLastname('Stark');
         $nedStark->setBirthdate(new \DateTime("1985-04-23"));
         $nedStark->setCreatedBy($testUser);
         $nedStark->addHome($starkHome);
         $manager->persist($nedStark);

         $catTully = new Relative();
         $catTully->setFirstname('Catelyn');
         $catTully->setLastname('Tully');
         $catTully->setBirthdate(new \DateTime("1984-07-11"));
         $catTully->setCreatedBy($testUser);
         $catTully->addHome($starkHome);
         $catTully->addHome($tullyHome);
         $manager->persist($catTully);
         
         $aryaStark = new Relative();
         $aryaStark->setFirstname('Arya');
         $aryaStark->setLastname('Stark');
         $aryaStark->setBirthdate(new \DateTime("2010-03-23"));
         $aryaStark->setCreatedBy($testUser);
         $aryaStark->addHome($starkHome);
         $manager->persist($aryaStark);
         
         $edTully = new Relative();
         $edTully->setFirstname('Edmure');
         $edTully->setLastname('Tully');
         $edTully->setBirthdate(new \DateTime("1986-02-11"));
         $edTully->setCreatedBy($testUser);
         $edTully->addHome($tullyHome);
         $manager->persist($edTully);
         
         $jonSnow = new Relative();
         $jonSnow->setFirstname('Jon');
         $jonSnow->setLastname('Snow');
         $jonSnow->setBirthdate(new \DateTime("2007-10-20"));
         $jonSnow->setCreatedBy($testUser);
         $manager->persist($jonSnow);

         $robertBaratheon = new Relative();
         $robertBaratheon->setFirstname('Robert');
         $robertBaratheon->setLastname('Baratheon');
         $robertBaratheon->setBirthdate(new \DateTime("1985-10-24"));
         $robertBaratheon->setCreatedBy($testUser);
         $robertBaratheon->addHome($baratheonHome);
         $manager->persist($robertBaratheon);

         $cerseiLannister = new Relative();
         $cerseiLannister->setFirstname('Cersei');
         $cerseiLannister->setLastname('Lannister');
         $cerseiLannister->setBirthdate(new \DateTime("1990-01-16"));
         $cerseiLannister->setCreatedBy($testUser);
         $cerseiLannister->addHome($lannisterHome);
         $manager->persist($cerseiLannister);

         $tyrionLannister = new Relative();
         $tyrionLannister->setFirstname('Tyrion');
         $tyrionLannister->setLastname('Lannister');
         $tyrionLannister->setBirthdate(new \DateTime("1997-08-17"));
         $tyrionLannister->setCreatedBy($testUser);
         $tyrionLannister->addHome($lannisterHome);
         $manager->persist($tyrionLannister);

        $manager->flush();
    }
}
