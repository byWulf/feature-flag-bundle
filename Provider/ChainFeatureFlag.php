<?php

declare(strict_types=1);

namespace Shopping\FeatureFlagBundle\Provider;

/**
 * Class ChainFeatureFlag.
 */
class ChainFeatureFlag implements FeatureFlagInterface
{
    /**
     * @var FeatureFlagInterface[]
     */
    private $providers = [];

    public function addProvider(FeatureFlagInterface $provider): void
    {
        $this->providers[] = $provider;
    }

    /**
     * @param string $featureFlag
     *
     * @return bool
     */
    public function isActive(string $featureFlag): bool
    {
        foreach ($this->providers as $provider) {
            if ($provider->isActive($featureFlag)) {
                return true;
            }
        }

        return false;
    }
}
