<?php

declare(strict_types=1);

namespace Shopping\FeatureFlagBundle\Provider;

/**
 * Class DotEnvFeatureFlag.
 */
class DotEnvFeatureFlag implements FeatureFlagInterface
{
    /**
     * @var bool
     */
    private $isEnabled;

    /**
     * @param bool $isEnabled
     */
    public function __construct(bool $isEnabled)
    {
        $this->isEnabled = $isEnabled;
    }

    /**
     * @param string $featureFlag
     *
     * @return bool
     */
    public function isActive(string $featureFlag): bool
    {
        if (!$this->isEnabled) {
            return false;
        }

        return (bool) getenv($this->buildEnvName($featureFlag));
    }

    /**
     * @param string $featureFlag
     *
     * @return string
     */
    private function buildEnvName(string $featureFlag): string
    {
        return 'FEATUREFLAG_' . mb_strtoupper($featureFlag);
    }
}
