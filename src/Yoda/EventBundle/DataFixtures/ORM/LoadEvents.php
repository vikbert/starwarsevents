<?php

namespace Yoda\EventBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Yoda\EventBundle\Entity\Event;

/**
 * Class LoadEvents
 * @package Yoda\EventBundle\DataFixtures\ORM
 */
class LoadEvents implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $event1 = new Event();
        $event1->setName('Darth\'s Birthday Party!');
        $event1->setLocation('Deathstar');
        $event1->setTime(new \DateTime('tomorrow noon'));
        $event1->setDetails('Ha! Darth HATES surprises!!!');
        $manager->persist($event1);


        $event3 = new Event();
        $event3->setName('Asia 2015 Symfony conference');
        $event3->setLocation('Beijing');
        $event3->setTime(new \DateTime('Thursday noon'));
        $event3->setDetails('Everybody who want to talk about symfony 2 framework');
        $manager->persist($event3);

        // the queries aren't done until now
        $manager->flush();
    }
}
