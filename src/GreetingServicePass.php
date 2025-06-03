<?php

namespace App;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class GreetingServicePass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $controllerDef = $container->getDefinition('App\User\Controller\UserController');
    }
}