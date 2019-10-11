<?php

declare(strict_types=1);

namespace Shopping\FeatureFlagBundle\Provider;

use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class CookieProvider.
 */
class CookieProvider extends AbstractValueProvider
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @param RequestStack $requestStack
     * @param string[]     $values
     */
    public function __construct(RequestStack $requestStack, array $values)
    {
        $this->requestStack = $requestStack;

        parent::__construct($values);
    }

    /**
     * @param string $featureFlag
     * @return string
     */
    protected function getValue(string $featureFlag): string
    {
        if ($this->requestStack->getCurrentRequest() === null) {
            return '';
        }

        return (string) $this->requestStack->getCurrentRequest()->cookies->get('featureFlag_' . $featureFlag);
    }
}
