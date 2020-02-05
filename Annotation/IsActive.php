<?php

declare(strict_types=1);

namespace Shopping\FeatureFlagBundle\Annotation;

/**
 * Class IsActive.
 *
 * @Annotation
 */
class IsActive
{
    /**
     * @var string
     */
    private $value;

    /**
     * IsActive constructor.
     *
     * @param string[] $values
     * @phpstan-param array{value: string} $values
     */
    public function __construct(array $values)
    {
        $this->value = $values['value'];
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }
}
