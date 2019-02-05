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

class OpenApiServerGenerator
{
    /**
     * @var OpenApi
     */
    private $openApi;
    /**
     * @var OpenApiEntityGenerator
     */
    private $openApiEntityGenerator;

    public function __construct(
        OpenApiEntityGenerator $openApiEntityGenerator
    ) {
        $this->openApiEntityGenerator = $openApiEntityGenerator;
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
     * @return OpenApiServerGenerator
     */
    public function setOpenApi(OpenApi $openApi): self
    {
        $this->openApi = $openApi;

        return $this;
    }

    public function generate(): self
    {
        $this->openApiEntityGenerator->setOpenApi($this->openApi)
            ->generate();

        // @TODO create custom controller actions for custom resources

        return $this;
    }
}