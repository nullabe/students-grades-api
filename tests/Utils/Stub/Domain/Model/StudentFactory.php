<?php

namespace StudentsGradesApi\Tests\Utils\Stub\Domain\Model;

use Ramsey\Uuid\Uuid;
use StudentsGradesApi\Domain\Model\Student;

class StudentFactory
{
    public static function getStudent(): Student
    {
        return new Student(Uuid::uuid4(), 'Antoine', 'Belluard', new \DateTime('13-11-1990'));
    }
}
