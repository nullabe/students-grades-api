<?php

declare(strict_types=1);

namespace StudentsGradesApi\Infrastructure\HttpApi\Symfony;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

final class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    private const CONFIG_BASE_PATH = '../../../../config';

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->import(self::CONFIG_BASE_PATH.'/{packages}/*.yaml');
        $container->import(self::CONFIG_BASE_PATH.'/{packages}/'.$this->environment.'/*.yaml');
        $container->import(self::CONFIG_BASE_PATH.'/services.yaml');
        $container->import(self::CONFIG_BASE_PATH.'/{services}_'.$this->environment.'.yaml');
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import(self::CONFIG_BASE_PATH.'/{routes}/'.$this->environment.'/*.yaml');
        $routes->import(self::CONFIG_BASE_PATH.'/{routes}/*.yaml');
        $routes->import(self::CONFIG_BASE_PATH.'/routes.yaml');
    }
}
