<?php

/**
 * This file is part of the ApiPlatformMakerBundle package.
 *
 * (c) Zsolt Restyanszki <rezsolt@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rezsolt\ApiPlatformMakerBundle\Command;

use Rezsolt\ApiPlatformMakerBundle\Entity\GeneratorSettings;
use Rezsolt\ApiPlatformMakerBundle\Entity\OpenApi;
use Rezsolt\ApiPlatformMakerBundle\Generator\OpenApiServerGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class GeneratorCommand
 *
 * @package Rezsolt\ApiPlatformMakerBundle\Command
 */
final class GeneratorCommand extends Command
{
    private $serializer;

    /**
     * @var OpenApiServerGenerator
     */
    private $apiServerGenerator;

    public function __construct(
        SerializerInterface $serializer,
        OpenApiServerGenerator $apiServerGenerator
    ) {
        $this->serializer = $serializer;
        $this->apiServerGenerator = $apiServerGenerator;

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('make:api')
            ->setDescription('Generate ApiPlatform server from OpenAPI 3.0 documentation')
            ->addArgument('openapi_doc_path', InputArgument::REQUIRED, 'OpenAPI 3.0 c JSON or yaml file')
            ->addOption(
                'path',
                null,
                InputOption::VALUE_REQUIRED,
                'The path where to generate entities when it cannot be guessed'
            )
            ->addOption('no-backup', null, InputOption::VALUE_NONE, 'Do not backup existing entities files.')
            ->addOption('regenerate', null, InputOption::VALUE_NONE, 'Instead of adding new fields, simply generate the methods (e.g. getter/setter) for existing fields')
            ->addOption('overwrite', null, InputOption::VALUE_NONE, 'Overwrite any existing getter/setter methods');
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $openApiDocPath = $input->getArgument('openapi_doc_path');
        $openApi = $this->loadDocumentation(
            $openApiDocPath,
            pathinfo($openApiDocPath, PATHINFO_EXTENSION) === 'yaml' ? 'yaml' : 'json'
        );
        $this->apiServerGenerator->setOpenApiEntity($openApi)
            ->setSettings(new GeneratorSettings($input->getOption('regenerate'), $input->getOption('overwrite')))
            ->generate();

        $io->success('Finished');
        $io->text(
            [
                'Next: It\'s time to create a migration with <comment>make:migration</comment>',
                '',
            ]
        );
    }

    private function loadDocumentation(string $filePath, string $format): OpenApi
    {
        if (!is_file($filePath) || !is_readable($filePath)) {
            throw new FileNotFoundException(sprintf('Documentation file "%s" not found or not readable.', $filePath));
        }

        $docSource = file_get_contents($filePath);
        /** @var OpenApi $openApi */
        $openApi = $this->serializer->deserialize($docSource, OpenApi::class, $format);

        return $openApi;
    }
}