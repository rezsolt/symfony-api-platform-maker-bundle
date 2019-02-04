<?php

/**
 * This file is part of the ApiPlatformMakerBundle package.
 *
 * (c) Zsolt Restyanszki <rezsolt@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rezsolt\ApiPlatformMakerBundle\Entity\OpenApi\Components\Schemas\Properties;

class Property
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var bool
     */
    private $readOnly;
    /**
     * @var string
     */
    private $type;
    /**
     * @var string
     */
    private $format;

    public function __construct(
        string $id,
        string $type,
        ?string $format = null,
        ?bool $readOnly = false
    ) {
        $this->id = $id;
        $this->readOnly = $readOnly;
        $this->type = $type;
        $this->format = $format;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isReadOnly(): bool
    {
        return $this->readOnly;
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
    public function getFormat(): string
    {
        return $this->format;
    }
}