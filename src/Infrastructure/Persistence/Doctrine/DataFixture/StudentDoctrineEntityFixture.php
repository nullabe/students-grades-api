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
            ->setUuid('eb6406cf-432d-4944-8122-a8dfb6ccdf4e')
            ->setFirstName('Xavier')
            ->setLastName('Dang')
            ->setBirthDate(new \DateTime('01-01-1990'))
        ;

        $studentAntoineDaniel = (new StudentDoctrineEntity())
            ->setUuid('ae13ebec-aec9-41e3-ac66-ea218cf89f7d')
            ->setFirstName('Antoine')
            ->setLastName('Daniel')
            ->setBirthDate(new \DateTime('01-01-1991'))
        ;

        $manager->persist($studentXavierDang);
        $manager->persist($studentAntoineDaniel);

        $manager->flush();
    }
}
