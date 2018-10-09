<?php
declare(strict_types=1);

namespace Shopping\FeatureFlagBundle\DependencyInjection;

use Shopping\FeatureFlagBundle\Provider\CookieProvider;
use Shopping\FeatureFlagBundle\Provider\DotEnvProvider;
use Shopping\FeatureFlagBundle\Provider\UserAgentProvider;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class ShoppingFeatureFlagExtension
 */
class ShoppingFeatureFlagExtension extends Extension
{

    /**
     * Loads a specific configuration.
     *
     * @param array            $configs
     * @param ContainerBuilder $container
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $definition = $container->getDefinition(DotEnvProvider::class);
        $definition->replaceArgument('$isEnabled', $config['providers']['dotEnv']['enabled']);

        $definition = $container->getDefinition(CookieProvider::class);
        $definition->replaceArgument('$isEnabled', $config['providers']['cookie']['enabled']);
        $definition->replaceArgument('$values', $config['providers']['cookie']['values']);

        $definition = $container->getDefinition(UserAgentProvider::class);
        $definition->replaceArgument('$isEnabled', $config['providers']['userAgent']['enabled']);
        $definition->replaceArgument('$values', $config['providers']['userAgent']['values']);
    }
}