<?php

declare(strict_types=1);

namespace Shopping\FeatureFlagBundle\EnvVarProcessor;

use Closure;
use Shopping\FeatureFlagBundle\Provider\FeatureFlagInterface;
use Symfony\Component\DependencyInjection\EnvVarProcessorInterface;

/**
 * Class FeatureFlagEnvVarProcessor.
 *
 * @package Shopping\FeatureFlagBundle\DependencyInjection
 */
class FeatureFlagEnvVarProcessor implements EnvVarProcessorInterface
{
    /**
     * @var FeatureFlagInterface
     */
    private $featureFlag;

    /**
     * FeatureFlagEnvVarProcessor constructor.
     *
     * @param FeatureFlagInterface $featureFlag
     */
    public function __construct(FeatureFlagInterface $featureFlag)
    {
        $this->featureFlag = $featureFlag;
    }

    /**
     * {@inheritdoc}
     */
    public function getEnv(/*string */$prefix, /*string */$name, Closure $getEnv)
    {
        return $this->featureFlag->isActive($name);
    }

    /**
     * {@inheritdoc}
     */
    public static function getProvidedTypes(): array
    {
        return [
            'feature_flag' => 'bool',
        ];
    }
}
