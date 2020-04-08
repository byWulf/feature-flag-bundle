<?php

declare(strict_types=1);

namespace Shopping\FeatureFlagBundle\Provider;

/**
 * Class DotEnvProvider.
 */
class DotEnvProvider implements FeatureFlagInterface
{
    /**
     * @param string $featureFlag
     *
     * @return bool
     */
    public function isActive(string $featureFlag): bool
    {
        $dotEnvName = $this->buildEnvName($featureFlag);
        $getEnv = (bool) getenv($dotEnvName);
        $dotEnv = !empty($_ENV[$dotEnvName]) ? (bool) $_ENV[$dotEnvName] : false;

        return $getEnv || $dotEnv;
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
