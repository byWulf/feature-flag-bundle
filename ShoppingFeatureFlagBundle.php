<?php

declare(strict_types=1);

namespace Shopping\FeatureFlagBundle;

use Shopping\FeatureFlagBundle\CompilerPass\FeatureFlagProviderPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class ShoppingFeatureFlagBundle.
 */
class ShoppingFeatureFlagBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new FeatureFlagProviderPass());
    }
}
