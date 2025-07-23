<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class Kernel extends BaseKernel
{
    use MicroKernelTrait {
        configureContainer as baseConfigureContainer;
        configureRoutes as baseConfigureRoutes;
    }

    protected function configureContainer(
        ContainerConfigurator $container,
        LoaderInterface $loader,
        ContainerBuilder $builder
    ): void
    {
        $this->baseConfigureContainer(container: $container, loader: $loader, builder: $builder);

        $srcDir = $this->getProjectDir() . '/src';

        $container->import(resource: $srcDir . '/**/{di}.php');
        $container->import(resource: $srcDir . "/**/{di}_$this->environment.php");
    }

    private function configureRoutes(RoutingConfigurator $routes): void
    {
        $this->baseConfigureRoutes(routes: $routes);

        $srcDir = $this->getProjectDir() . '/src';

        $routes->import(resource: $srcDir . '/**/{routing}.php');
        $routes->import(resource: $srcDir . "/**/{routing}_{$this->environment}.php");
    }
}
