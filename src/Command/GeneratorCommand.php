<?php

namespace Rezsolt\ApiPlatformMakerBundle\Command;

use ApiPlatform\Core\Metadata\Resource\Factory\ResourceNameCollectionFactoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Class GeneratorCommand
 *
 * @package Rezsolt\ApiPlatformMakerBundle\Command
 */
final class GeneratorCommand extends Command
{
    private $normalizer;
    private $resourceNameCollectionFactory;

    public function __construct(
        NormalizerInterface $normalizer,
        ResourceNameCollectionFactoryInterface $resourceNameCollection
    ) {
        $this->normalizer = $normalizer;
        $this->resourceNameCollectionFactory = $resourceNameCollection;

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
            ->addArgument('input', InputArgument::REQUIRED, 'OpenAPI 3.0 documentation JSON or yaml file');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $io->success('Finished');
    }
}