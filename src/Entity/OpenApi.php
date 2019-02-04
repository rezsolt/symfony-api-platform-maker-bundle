<?php

/**
 * This file is part of the ApiPlatformMakerBundle package.
 *
 * (c) Zsolt Restyanszki <rezsolt@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rezsolt\ApiPlatformMakerBundle\Entity;

use Rezsolt\ApiPlatformMakerBundle\Entity\OpenApi\Components;
use Rezsolt\ApiPlatformMakerBundle\Entity\OpenApi\Info;
use Rezsolt\ApiPlatformMakerBundle\Entity\OpenApi\Paths;

final class OpenApi
{
    /**
     * @var string
     */
    private $openapi;
    /**
     * @var Info
     */
    private $info;
    /**
     * @var Paths
     */
    private $paths;
    /**
     * @var Components
     */
    private $components;

    public function __construct(
        string $openapi,
        Info $info,
        Paths $paths,
        Components $components
    ) {
        $this->openapi = $openapi;
        $this->info = $info;
        $this->paths = $paths;
        $this->components = $components;
    }

    /**
     * @return string
     */
    public function getOpenapi(): string
    {
        return $this->openapi;
    }

    /**
     * @return Info
     */
    public function getInfo(): Info
    {
        return $this->info;
    }

    /**
     * @return Paths
     */
    public function getPaths(): Paths
    {
        return $this->paths;
    }

    /**
     * @return Components
     */
    public function getComponents(): Components
    {
        return $this->components;
    }
}