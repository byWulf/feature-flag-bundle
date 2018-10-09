<?php
declare(strict_types=1);

namespace Shopping\FeatureFlagBundle\Provider;

/**
 * Class AbstractValueProvider
 * @package Shopping\FeatureFlagBundle\Provider
 */
abstract class AbstractValueProvider implements FeatureFlagInterface
{
    /**
     * @var array|string[]
     */
    private $values;

    /**
     * @param array $values
     */
    public function __construct(array $values)
    {
        $this->values = $values;
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

        return in_array($this->getValue($featureFlag), $this->values[$featureFlag], true);
    }

    /**
     * Returns the value given by the user.
     *
     * @param string $featureFlag
     * @return string
     */
    abstract protected function getValue(string $featureFlag): string;
}