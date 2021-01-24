# Students' Grades API

A RESTFull API to manage students' grades. Written in PHP8, using Symfony5 framework.
Implemented by using Hexagonal Architecture with CQRS and (some) DDD principles.

## Architecture

* src
    * Application
        * Query
            * GetStudentGradeAverage
                * GetStudentGradeAverageQuery
                * GetStudentGradeAverageViewModel
            * GetAllStudentsGradeAverage
                * GetAllStudentsGradeAverageQuery
                * GetAllStudentsGradeAverageViewModel
        * Command
            * AddStudent
                * AddStudentCommand
                * AddStudentCommandHandler
                * AddStudentCommandResponse
            * UpdateStudent
                * UpdateStudentCommand
                * UpdateStudentCommandHandler
                * UpdateStudentCommandResponse
            * DeleteStudent
                * DeleteStudentCommand
                * DeleteStudentCommandHandler
                * DeleteStudentCommandResponse
            * AddGradeToStudent
                * AddGradeToStudentCommand
                * AddGradeToStudentCommandHandler
                * AddGradeToStudentCommandResponse
        * Shared
            * Bus
                * BusMiddlewareInterface
                * CommandBusDispatcher
                * QueryBusDispatcher       
            * Command
                * CommandHandlerInterface
                * CommandResponseInterface
            * Query
                * QueryHandlerInterface
                * ViewModelInterface
    * Domain
        * Entity
            * Student
        * Repository
            * StudentRepositoryInterface
        * ValueObject
            * Grade
    * Infrastructure
        * Bus
            * Middleware
                * Monolog
                    * MonologLoggerBusMiddleware
                * Symfony
                    * SymfonyCacheBusMiddleware
                * Doctrine
                    * DoctrineFlushBushMiddleware
        * HttpApi
            * Symfony
                * Controller
                    * Student
                        * Get
                            * GetStudentGradeAverageController
                            * GetAllStudentsGradeAverageController
                        * Post
                            * AddStudentController
                            * AddGradeToStudentController
                        * Put
                            * UpdateStudentController
                        * Delete
                            * DeleteStudentController
        * Persistence
            * Doctrine
                * Repository
                    * StudentRepository
                * QueryHandler
                    * GetStudentGradeAverageQueryHandler
                    * GetAllStudentsGradeAverageQueryHandler


* https://speakerdeck.com/lilobase/ddd-and-cqrs-php-tour-2018?slide=19



## HTTP Routes
    
* GET /students/{uuid}/grades/average
* GET /students/grades/average
* POST /students
* POST /students/{uuid}/grades
* PUT /students/{uuid}
* DELETE /students/{uuid}


## Todo :

[ ] composer.json bootstrap

[ ] install quality&tests cs-fixer phpstan phpunit

[ ] makefile : quality/test/test-class/test-coverage

[ ] tdd domain & application

[ ] install symfony 5 & doctrine

[ ] docker configuration

[ ] makefile : install/cc/exec

[ ] tdd infrastructure

[ ] documentation on README (+ don't forget the swagger)

## Go further

-> declare the student entity as aggregate root to do event-sourcing

-> add a command bus to add middlewares on command/query