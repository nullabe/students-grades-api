# Students' Grades API

A RESTFull API to manage students' grades. Written in PHP8, using Symfony5 framework.
Implemented by using Hexagonal Architecture with CQRS.

## Installation

### Prerequisites

To build and run the project, you must check that your computer has these programs installed
* Bash/Zsh terminal
* Make
* Docker (with docker-compose)

### Build project

All commands to install & run the project are encapsulated into the Makefile at project root. 
To install the project, simply type this into your terminal.

```
make install
```

### Start & stop the project

This will download docker images, run composer install, build databases and check quality.
Once command is over, you can type this to start the containers.

```
make start
```

**The API is now available at `http://127.0.0.1:8080`**

To stop the containers, use this make directive

```
make stop
```

Container configuration with docker-composer.yml as well, are available into `./deploy/docker/dev` folder.

## Usage

### API documentation
As this project is an HTTP API, all endpoints are specified into an OpenAPI v3 documentation.

The documentation is available at `./config/statics/openapi_specifications.yaml`. 
As YAML is not really a human-readable format, 
the use of OpenAPI format is very useful to bootstrap a Swagger UI to read documentation.

You can quickly run the Swagger UI, with this make directive

```
make start-doc
```

Now the HTTP API documentation is available at `http://127.0.0.1:8081`.

Once you finished, you can stop the documentation with 

```
make stop-doc
```

### Start playing with API !

Once the project's containers are started, you can use the API with Postman or any HTTP Client you like.

## Tests & Quality

### Tests usage

All tests are written using PHPUnit, they are all into `./tests` folder. 
Some make directive can help you during development part.

#### Run test suite

```
make test
```

#### Run a single test class

```
make test-class class=MyTestClass
```

#### Run test suite with coverage

```
make test-coverage
```

### Tests notes

For the coverage report, this project uses PCOV, a PHP7+ extension, 
a lot faster than xdebug because its only purpose is to calculate coverage.

To make sure functional tests are isolated (a very important principle), 
the project is using PHPUnit extension `DAMA\DoctrineTestBundle`. It works very well without any configuration. The only drawback, is that
this doesn't work on functional part using SQL transactions. So, it works in our case, but if you have some transactions, you must disable it and maybe write your own extension.

### Quality

Checking code quality automatically is a really important part of development process. It will reduce review time on basic mistakes, enforce
some cohesion on code base and also add some important verifications.

This project is using CS-Fixer to the cohesion part and PHPStan at max level for the rest.

#### Run cs-fix to correct files

```
make cs-fix
```

#### Run quality checks

```
make quality
```

## Project architecture

### CQRS & Hexagonal Architecture

This project was developed by using Hexagonal architecture. The point of that, is to separate business logic from infrastructure (eg: framework, ORM, ...).
On top of that, all project user requests were designed with Command Query Responsibility Separation (CQRS) pattern. The aim is to have Commands (model mutation) 
decoupled from Query (read model).

So in this kind of architecture, you think use cases first, this is the entry point for modeling. It also works very well with TDD.

In this application use cases were :
* AddStudent
* AddGradeToStudent
* DeleteStudent
* UpdateStudent
* GetAllStudentsGradeAverage
* GetStudentGradeAverage

You can easily see what are commands and what are queries.

A drawback of a hexagonal architecture, is that you must think differently from a classic CRUD application, 
this obviously leads to more reflexion about naming and code responsibility and more code to write.

Hexagonal architectures are also named "screaming architecture", because by looking at project directories and class names,
it's possible to see what's the application is doing and what it's using to work.

### Why not using API-Platform

I use API-Platform daily, and I must admit, it's a very cool tool to scaffold very quickly an API from Doctrine entities. You only have to write configuration files, and the job is done.

Contrariwise, it can be tricky to use when you have to implement custom endpoints only designed to answer to custom client use cases,
and commonly leads to a lot of class override and big managers. 
In my opinion, it mustn't be used systematically on all PHP API projects, its usefulness must be debated before development start (as a lot of things you will say).

Moreover, only with symfony, you can build an HTTP API really fast
with the http-foundation component and the wonderful serializer component. All the tools are already here.

### PHP 8

PHP 8 is a very big step up for the language. Attributes, match pattern (goodbye ugly but needed switch cases), class property promotion and more... 
this adds a lot of new tools to build cool stuff with a more and more cohesive and stable code (if you are using strict types from PHP7.4 :D).

### Going further with Command Bus pattern

So after that, what's the next steps for this project ?

This architecture enables the use of the Command Bus pattern. The command bus is a chain of middlewares that ultimately leads to a command/query(/event) dispatcher.
The middlewares can be pushed on the bus with any order, they must implement the same interface and every one of them must call the next one. The last middleware is called a `CommandDispatcher`,
it simply dispatches the command/query to the associated handler.

This can be very useful to implement transversal code like logs (with Monolog), cache (symfony or external like redis/memcached/...) or authentication.

Some middleware examples :
* **Cache middleware**: Check if the query handler result value is in the cache (and not expired of course), if yes, it stops the chain and directly returns the cache value.
* **Logger middleware** : Log what happens in the handler and when.
* **Request headers verifications Middleware** : Check if request has the required headers (content-type)
* **Authentication Middleware** : Can check on an authentication provider if bearer token is valid and authorized to access the resource.

## Resources links

* Arnaud Lemaire's talk about DDD/CQRS at PHPTour 2018 : https://www.youtube.com/watch?v=qBLtZN3p3FU
* Jean-Marie Lamodière's talk about Meetic legacy migration to DDD architecture at ForumPHP 2019 : https://www.youtube.com/watch?v=tdE5wE5MvsI
* An interesting take on why we must use a lot of Command pattern but not implements CQRS everytime : https://dev.to/ludofleury/domain-driven-design-with-php-and-symfony-1bl6

----

**Thanks for the reading !**
