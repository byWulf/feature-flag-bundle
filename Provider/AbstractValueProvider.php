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
     * @var bool
     */
    private $isEnabled;
    /**
     * @var array|string[]
     */
    private $values;

    /**
     * @param bool  $isEnabled
     * @param array $values
     */
    public function __construct(bool $isEnabled, array $values)
    {
        $this->isEnabled = $isEnabled;
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
        if (!$this->isEnabled) {
            return false;
        }

        if (!isset($this->values[$featureFlag])) {
            return false;
        }

        return $this->isValidValue($featureFlag, $this->getValue($featureFlag));
    }

    /**
     * @param string $featureFlag
     * @param string $value
     * @return bool
     */
    private function isValidValue(string $featureFlag, string $value): bool
    {
        $neededValues = $this->values[$featureFlag];
        if (!is_array($neededValues)) {
            $neededValues = [$neededValues];
        }

        foreach ($neededValues as $neededValue) {
            if ((string) $neededValue === $value) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns the value given by the user.
     *
     * @param string $featureFlag
     * @return string
     */
    abstract protected function getValue(string $featureFlag): string;
}