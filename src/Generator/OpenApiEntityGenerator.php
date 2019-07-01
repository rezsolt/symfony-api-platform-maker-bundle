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

use ApiPlatform\Core\Annotation\ApiResource;
use Rezsolt\ApiPlatformMakerBundle\Entity\GeneratorSettings;
use Rezsolt\ApiPlatformMakerBundle\Entity\OpenApi;
use Rezsolt\ApiPlatformMakerBundle\Entity\OpenApi\Components\Schemas\Properties\Property;
use Rezsolt\ApiPlatformMakerBundle\Entity\OpenApi\Components\Schemas\Schema;
use Symfony\Bundle\MakerBundle\Doctrine\EntityClassGenerator;
use Symfony\Bundle\MakerBundle\FileManager;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\Util\ClassDetails;
use Symfony\Bundle\MakerBundle\Util\ClassSourceManipulator;

/**
 * The OpenApiEntityGenerator class generates entities with ApiPlatform annotations based on the OpenAPI schema.
 *
 * Entity generation based on the \Symfony\Bundle\MakerBundle\Maker\MakeEntity class.
 *
 * @author Zsolt Restyánszki <rezsolt@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 * @author Ryan Weaver <weaverryan@gmail.com>
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class OpenApiEntityGenerator
{
    /**
     * @var OpenApi
     */
    private $openApiEntity;

    /**
     * @var Generator
     */
    private $generator;

    /**
     * @var EntityClassGenerator
     */
    private $entityClassGenerator;

    /**
     * @var FileManager
     */
    private $fileManager;

    /**
     * @var GeneratorSettings
     */
    private $settings;

    public function __construct(
        Generator $generator,
        FileManager $fileManager,
        EntityClassGenerator $entityClassGenerator
    ) {
        $this->entityClassGenerator = $entityClassGenerator;
        $this->generator = $generator;
        $this->fileManager = $fileManager;
    }

    /**
     * @return OpenApi
     *
     * @throws \BadMethodCallException
     */
    public function getOpenApiEntity(): OpenApi
    {
        if ($this->openApiEntity === null) {
            throw new \BadMethodCallException('OpenApi did not set.');
        }

        return $this->openApiEntity;
    }

    /**
     * @param OpenApi $openApiEntity
     *
     * @return OpenApiEntityGenerator
     */
    public function setOpenApiEntity(OpenApi $openApiEntity): self
    {
        $this->openApiEntity = $openApiEntity;

        return $this;
    }

    public function generate(): self
    {
        $openApi = $this->getOpenApiEntity();

        /** @var Schema $schema */
        foreach ($openApi->getComponents()->getSchemas() as $schema) {
            $entityPath = $this->generateNewEntity($schema);
            $classManipulator = $this->createClassManipulator($entityPath);
            $this->createFields($classManipulator, $entityPath, $schema);

            // @TODO create/update entities
            // @TODO add annotations for the path/method settings
            // @TODO create/update relations

        }


        return $this;
    }

    private function generateNewEntity(Schema $schema)
    {
        $entityClassDetails = $this->generator->createClassNameDetails(
            $schema->getId(),
            'Entity\\'
        );
        $classExists = class_exists($entityClassDetails->getFullName());

        if ($classExists) {
            $entityPath = $this->getPathOfClass($entityClassDetails->getFullName());

            if (!$this->settings->isRegenerateEntities()) {
                return $entityPath;
            }
        }
        
        $entityPath = $this->entityClassGenerator->generateEntityClass($entityClassDetails, true);
        $this->generator->writeChanges();
        
        return $entityPath;
    }

    private function createClassManipulator(string $path): ClassSourceManipulator
    {
        $manipulator = new ClassSourceManipulator(
            $this->fileManager->getFileContents($path),
            $this->settings->isOverwriteMethods()
        );

        return $manipulator;
    }

    private function createFields(ClassSourceManipulator $classManipulator, string $entityPath, Schema $schema)
    {
        $fileManagerOperations = [];
        $fileManagerOperations[$entityPath] = $classManipulator;

        /** @var Property $property */
        foreach ($schema->getProperties() as $property) {
            $annotationOptions = [
                'type' => $property->getType()
//                'nullable' => $property->
//                'id' => $property->
            ];
            $classManipulator->addEntityField($property->getId(), $annotationOptions);
        }

        foreach ($fileManagerOperations as $path => $manipulator) {
            $this->fileManager->dumpFile($path, $manipulator->getSourceCode());
        }
    }

    private function getPathOfClass(string $class)
    {
        $classDetails = new ClassDetails($class);

        return $classDetails->getPath();
    }

    /**
     * @param GeneratorSettings $settings
     *
     * @return OpenApiServerGenerator
     */
    public function setSettings(GeneratorSettings $settings): self
    {
        $this->settings = $settings;

        return $this;
    }
}