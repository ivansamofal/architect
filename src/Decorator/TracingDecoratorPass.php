<?php

namespace App\Decorator;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class TracingDecoratorPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        foreach ($container->findTaggedServiceIds('app.traceable') as $id => $tags) {
            $definition = $container->getDefinition($id);

            $decoratedDef = $container->register($id.'.traceable', TraceDecorator::class)
                ->setDecoratedService($id)
                ->setArguments([
                    new Reference($id.'.traceable.inner'),
                    new Reference('App\\Tracing\\JaegerTracerProvider'),
                    new Reference('logger'),
                    $id,
                ])
                ->setPublic(true);
        }
    }
}
