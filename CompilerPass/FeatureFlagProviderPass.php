<?php
declare(strict_types=1);

namespace Shopping\FeatureFlagBundle\CompilerPass;

use Shopping\FeatureFlagBundle\Provider\ChainProvider;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class FeatureFlagProviderPass
 */
class FeatureFlagProviderPass implements CompilerPassInterface
{

    /**
     * You can modify the container here before it is dumped to PHP code.
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(ChainProvider::class)) {
            return;
        }

        $definition = $container->findDefinition(ChainProvider::class);

        $taggedServices = $container->findTaggedServiceIds('featureFlag.provider');
        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addProvider', [new Reference($id)]);
        }
    }
}