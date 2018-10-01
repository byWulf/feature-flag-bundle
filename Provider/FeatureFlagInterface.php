<?php

declare(strict_types=1);

namespace Shopping\FeatureFlagBundle\Provider;

/**
 * Interface FeatureFlagInterface.
 */
interface FeatureFlagInterface
{
    /**
     * Returns true, if this FeatureFlag is set and active.
     *
     * @param string $featureFlag
     *
     * @return bool
     */
    public function isActive(string $featureFlag): bool;
}
