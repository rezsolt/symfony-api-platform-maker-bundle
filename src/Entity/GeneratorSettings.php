<?php

namespace Rezsolt\ApiPlatformMakerBundle\Entity;

/**
 * Class GeneratorSettings.
 */
final class GeneratorSettings
{
    /**
     * @var bool
     */
    private $regenerateEntities = false;

    /**
     * @var bool
     */
    private $overwriteMethods = false;

    /**
     * GeneratorSettings constructor.
     *
     * @param bool $regenerateEntities
     * @param bool $overwriteMethods
     */
    public function __construct(bool $regenerateEntities, bool $overwriteMethods)
    {
        $this->regenerateEntities = $regenerateEntities;
        $this->overwriteMethods = $overwriteMethods;
    }

    /**
     * @return bool
     */
    public function isRegenerateEntities(): bool
    {
        return $this->regenerateEntities;
    }

    /**
     * @return bool
     */
    public function isOverwriteMethods(): bool
    {
        return $this->overwriteMethods;
    }
}