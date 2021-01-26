<?php

declare(strict_types=1);

namespace StudentsGradesApi\Infrastructure\Persistence\Doctrine\DataFixture;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use StudentsGradesApi\Infrastructure\Persistence\Doctrine\Entity\StudentDoctrineEntity;

final class StudentDoctrineEntityFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $studentXavierDang = (new StudentDoctrineEntity())
            ->setUuid('xavierdang')
            ->setFirstName('Xavier')
            ->setLastName('Dang')
            ->setBirthDate(new \DateTime('01-01-1990'))
        ;

        $studentAntoineDaniel = (new StudentDoctrineEntity())
            ->setUuid('antoinedaniel')
            ->setFirstName('Antoine')
            ->setLastName('Daniel')
            ->setBirthDate(new \DateTime('01-01-1991'))
        ;

        $manager->persist($studentXavierDang);
        $manager->persist($studentAntoineDaniel);
    }
}
