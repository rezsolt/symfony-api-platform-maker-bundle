<?php

/**
 * This file is part of the ApiPlatformMakerBundle package.
 *
 * (c) Zsolt Restyanszki <rezsolt@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rezsolt\ApiPlatformMakerBundle\Entity\OpenApi\Components\Schemas;

class Schema
{
    /**
     * @var string
     */
    private $type;
    /**
     * @var string
     */
    private $description;
    /**
     * @var Properties
     */
    private $properties;

    public function __construct(
        string $type,
        string $description,
        Properties $properties
    ) {
        $this->type = $type;
        $this->description = $description;
        $this->properties = $properties;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return Properties
     */
    public function getProperties(): Properties
    {
        return $this->properties;
    }
}