<?php

/**
 * This file is part of the ApiPlatformMakerBundle package.
 *
 * (c) Zsolt Restyanszki <rezsolt@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rezsolt\ApiPlatformMakerBundle\Generator;

use Rezsolt\ApiPlatformMakerBundle\Entity\OpenApi;
use Symfony\Bundle\MakerBundle\Generator;

class OpenApiEntityGenerator
{
    /**
     * @var OpenApi
     */
    private $openApi;

    /**
     * @var Generator
     */
    private $generator;

    public function __construct(
        Generator $generator
    ) {
        $this->generator = $generator;
    }

    /**
     * @return OpenApi
     */
    public function getOpenApi(): OpenApi
    {
        return $this->openApi;
    }

    /**
     * @param OpenApi $openApi
     *
     * @return OpenApiEntityGenerator
     */
    public function setOpenApi(OpenApi $openApi): self
    {
        $this->openApi = $openApi;

        return $this;
    }

    public function generate(): self
    {
        // @TODO create/update entities
        // @TODO add annotations for the path/method settings
        // @TODO create/update relations

        return $this;
    }
}