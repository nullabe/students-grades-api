<?php

declare(strict_types=1);

namespace StudentsGradesApi\Infrastructure\Persistence\Doctrine\DataFixture;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use StudentsGradesApi\Infrastructure\Persistence\Doctrine\Entity\GradeDoctrineEntity;
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

        $studentXavierDang
            ->addGrade(
                (new GradeDoctrineEntity())->setSubject('Histoire')->setValue(13)->setStudent($studentXavierDang)
            )
            ->addGrade(
                (new GradeDoctrineEntity())->setSubject('Physique')->setValue(18)->setStudent($studentXavierDang)
            )
            ->addGrade(
                (new GradeDoctrineEntity())->setSubject('Maths')->setValue(20)->setStudent($studentXavierDang)
            )
        ;

        $studentAntoineDaniel
            ->addGrade(
                (new GradeDoctrineEntity())->setSubject('Histoire')->setValue(12)->setStudent($studentAntoineDaniel)
            )
            ->addGrade(
                (new GradeDoctrineEntity())->setSubject('Physique')->setValue(17)->setStudent($studentAntoineDaniel)
            )
            ->addGrade(
                (new GradeDoctrineEntity())->setSubject('Maths')->setValue(19)->setStudent($studentAntoineDaniel)
            )
        ;

        $manager->persist($studentXavierDang);
        $manager->persist($studentAntoineDaniel);

        $manager->flush();
    }
}
