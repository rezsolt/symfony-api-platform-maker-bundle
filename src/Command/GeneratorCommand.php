<?php

namespace Rezsolt\ApiPlatformMakerBundle\Command;

use Rezsolt\ApiPlatformMakerBundle\Entity\OpenApi;
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

    public function __construct(
        SerializerInterface $serializer
    ) {
        $this->serializer = $serializer;

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
            ->addOption('yaml', 'y', InputOption::VALUE_NONE, 'Dump the documentation in YAML');
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $openApi = $this->loadDocumentation($input->getArgument('openapi_doc_path'), $input->getOption('yaml') ? 'yaml' : 'json');

        // @TODO create/update entities
        // @TODO add annotations for the path/method settings
        // @TODO create/update relations
        // @TODO create custom controller actions for custom resources

        $io->success('Finished');
        $io->text([
            'Next: It\'s time to create a migration with <comment>make:migration</comment>',
            '',
        ]);
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