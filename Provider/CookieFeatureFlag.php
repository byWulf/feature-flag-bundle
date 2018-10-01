<?php

declare(strict_types=1);

namespace Shopping\FeatureFlagBundle\Provider;

use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class CookieFeatureFlag.
 */
class CookieFeatureFlag implements FeatureFlagInterface
{
    /**
     * @var RequestStack
     */
    private $requestStack;
    /**
     * @var bool
     */
    private $isEnabled;
    /**
     * @var array|string[]
     */
    private $values;

    /**
     * @param RequestStack $requestStack
     * @param bool         $isEnabled
     * @param string[]     $values
     */
    public function __construct(RequestStack $requestStack, bool $isEnabled, array $values)
    {
        $this->requestStack = $requestStack;
        $this->isEnabled = $isEnabled;
        $this->values = $values;
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

        $value = $this->requestStack->getCurrentRequest()->cookies->get($this->buildCookieName($featureFlag));

        if (isset($this->values[$featureFlag])) {
            return (string) $this->values[$featureFlag] === $value;
        }

        return (bool) $value;
    }

    /**
     * @param string $featureFlag
     *
     * @return string
     */
    private function buildCookieName(string $featureFlag): string
    {
        return 'featureFlag_' . $featureFlag;
    }
}
