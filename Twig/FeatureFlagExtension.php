<?php

namespace Shopping\FeatureFlagBundle\Twig;

use Shopping\FeatureFlagBundle\Provider\FeatureFlagInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class FeatureFlagExtension.
 */
class FeatureFlagExtension extends AbstractExtension
{
    /**
     * @var FeatureFlagInterface
     */
    private $featureFlag;

    /**
     * @param FeatureFlagInterface $featureFlag
     */
    public function __construct(FeatureFlagInterface $featureFlag)
    {
        $this->featureFlag = $featureFlag;
    }

    /**
     * @return array|\Twig_Function[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('is_active', [$this, 'isActiveFeatureFlag']),
        ];
    }

    /**
     * @param string $featureFlag
     *
     * @return bool
     */
    public function isActiveFeatureFlag(string $featureFlag): bool
    {
        return $this->featureFlag->isActive($featureFlag);
    }
}
