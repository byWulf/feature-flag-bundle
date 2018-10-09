<?php

declare(strict_types=1);

namespace Shopping\FeatureFlagBundle\Provider;

use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class UserAgentProvider.
 */
class UserAgentProvider implements FeatureFlagInterface
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
    private $userAgents;

    /**
     * @param RequestStack $requestStack
     * @param bool         $isEnabled
     * @param string[]     $userAgents
     */
    public function __construct(RequestStack $requestStack, bool $isEnabled, array $userAgents)
    {
        $this->requestStack = $requestStack;
        $this->isEnabled = $isEnabled;
        $this->userAgents = $userAgents;
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

        if (!isset($this->userAgents[$featureFlag])) {
            return false;
        }

        $userAgent = $this->requestStack->getCurrentRequest()->headers->get('User-Agent');

        return (string) $this->userAgents[$featureFlag] === $userAgent;
    }
}
