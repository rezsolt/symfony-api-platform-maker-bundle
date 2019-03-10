<?php

/**
 * This file is part of the ApiPlatformMakerBundle package.
 *
 * (c) Zsolt Restyanszki <rezsolt@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rezsolt\ApiPlatformMakerBundle\Entity\OpenApi;

final class Info
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $version;

    public function __construct(
        string $title,
        string $version
    ) {
        $this->title = $title;
        $this->version = $version;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }
}