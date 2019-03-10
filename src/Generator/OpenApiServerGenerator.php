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

use Rezsolt\ApiPlatformMakerBundle\Entity\GeneratorSettings;
use Rezsolt\ApiPlatformMakerBundle\Entity\OpenApi;

class OpenApiServerGenerator
{
    /**
     * @var OpenApi
     */
    private $openApiEntity;

    /**
     * @var OpenApiEntityGenerator
     */
    private $openApiEntityGenerator;

    /**
     * @var GeneratorSettings
     */
    private $settings;

    public function __construct(
        OpenApiEntityGenerator $openApiEntityGenerator
    ) {
        $this->openApiEntityGenerator = $openApiEntityGenerator;
    }

    /**
     * @return OpenApi
     */
    public function getOpenApiEntity(): OpenApi
    {
        return $this->openApiEntity;
    }

    /**
     * @param OpenApi $openApiEntity
     *
     * @return OpenApiServerGenerator
     */
    public function setOpenApiEntity(OpenApi $openApiEntity): self
    {
        $this->openApiEntity = $openApiEntity;

        return $this;
    }

    /**
     * @return OpenApiServerGenerator
     */
    public function generate(): self
    {
        $this->openApiEntityGenerator->setOpenApiEntity($this->openApiEntity)
            ->generate();

        // @TODO create custom controller actions for custom resources

        return $this;
    }

    /**
     * @param GeneratorSettings $settings
     *
     * @return OpenApiServerGenerator
     */
    public function setSettings(GeneratorSettings $settings): self
    {
        $this->settings = $settings;
        $this->openApiEntityGenerator->setSettings($settings);

        return $this;
    }
}