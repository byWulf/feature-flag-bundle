<?php

declare(strict_types=1);

namespace Shopping\FeatureFlagBundle\Provider;

use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class UserAgentProvider.
 */
class UserAgentProvider extends AbstractValueProvider
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @param RequestStack $requestStack
     * @param string[][]        $values
     */
    public function __construct(RequestStack $requestStack, array $values)
    {
        $this->requestStack = $requestStack;

        parent::__construct($values);
    }

    /**
     * Returns true, if this FeatureFlag is set and active.
     *
     * @param string $featureFlag
     *
     * @return bool
     */
    public function isActive(string $featureFlag): bool
    {
        if (!isset($this->values[$featureFlag])) {
            return false;
        }

        foreach ($this->values[$featureFlag] as $neededValue) {
            if (strpos($this->getValue($featureFlag), $neededValue) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns the value given by the user.
     *
     * @param string $featureFlag
     *
     * @return string
     */
    protected function getValue(string $featureFlag): string
    {
        if ($this->requestStack->getCurrentRequest() === null) {
            return '';
        }

        return (string) $this->requestStack->getCurrentRequest()->headers->get('User-Agent');
    }
}
