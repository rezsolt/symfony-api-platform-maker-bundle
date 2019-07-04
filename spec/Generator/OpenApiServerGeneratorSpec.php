<?php

namespace spec\Rezsolt\ApiPlatformMakerBundle\Generator;

use Rezsolt\ApiPlatformMakerBundle\Entity\GeneratorSettings;
use Rezsolt\ApiPlatformMakerBundle\Entity\OpenApi;
use Rezsolt\ApiPlatformMakerBundle\Generator\OpenApiEntityGenerator;
use Rezsolt\ApiPlatformMakerBundle\Generator\OpenApiServerGenerator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class OpenApiServerGeneratorSpec extends ObjectBehavior
{
    public function let(
        OpenApiEntityGenerator $openApiEntityGenerator
    ) {
        $this->beConstructedWith($openApiEntityGenerator);
    }

    public function it_is_initializable() {
        $this->shouldHaveType(OpenApiServerGenerator::class);
    }

    public function it_should_accept_and_return_the_open_api_entity(
        OpenApi $openApiEntity
    ) {
        $this->setOpenApiEntity($openApiEntity);
        $this->getOpenApiEntity()->shouldBe($openApiEntity);
    }

    public function it_should_call_entity_generator(
        OpenApiEntityGenerator $openApiEntityGenerator,
        GeneratorSettings $generatorSettings,
        OpenApi $openApiEntity
    ) {
        $openApiEntityGenerator->setSettings($generatorSettings)->shouldBeCalled()->willReturn($openApiEntityGenerator);
        $openApiEntityGenerator->setOpenApiEntity($openApiEntity)->shouldBeCalled()->willReturn($openApiEntityGenerator);
        $openApiEntityGenerator->generate()->shouldBeCalled()->willReturn($openApiEntityGenerator);

        $this->setSettings($generatorSettings);
        $this->setOpenApiEntity($openApiEntity);
        $this->generate()->shouldBe($this);
    }
}
