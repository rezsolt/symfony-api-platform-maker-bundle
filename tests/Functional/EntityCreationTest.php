<?php

declare(strict_types=1);

namespace Rezsolt\ApiPlatformMakerBundle\Tests\Functional;

use PHPUnit\Framework\ExpectationFailedException;
use SebastianBergmann\RecursionContext\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\ApplicationTester;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Exception\DirectoryNotFoundException;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

final class EntityCreationTest extends KernelTestCase
{
    /**
     * @var string
     */
    private static $examplesPath;

    /**
     * @var ApplicationTester
     */
    private $tester;

    /**
     * @var string
     */
    private static $srcPath;

    /**
     * @var string
     */
    private static $entityPath;

    /**
     * @var string
     */
    private static $repoPath;

    public static function initPath(): void
    {
        if (self::$srcPath !== null) {
            return;
        }

        $testPath = realpath(__DIR__.\DIRECTORY_SEPARATOR.'..').\DIRECTORY_SEPARATOR;
        self::$srcPath = $testPath.'temp_src'.\DIRECTORY_SEPARATOR;
        self::$entityPath = self::$srcPath.'Entity'.\DIRECTORY_SEPARATOR;
        self::$repoPath = self::$srcPath.'Repository'.\DIRECTORY_SEPARATOR;
        self::$examplesPath = $testPath.'Fixtures'.\DIRECTORY_SEPARATOR.'examples'.\DIRECTORY_SEPARATOR;

        if (!is_dir(self::$entityPath)) {
            mkdir(self::$entityPath);
        }

        if (!is_dir(self::$repoPath)) {
            mkdir(self::$repoPath);
        }
    }

    public static function setUpBeforeClass(): void
    {
        self::initPath();
    }

    public function dataExamples(): \Generator
    {
        self::initPath();

        $finder = new Finder();
        $finder->directories()
            ->in(self::$examplesPath)
            ->depth(0);

        if (!$finder->hasResults()) {
            throw new \LogicException('Missing examples');
        }

        /** @var SplFileInfo $dir */
        foreach ($finder as $dir) {
            if (file_exists($dir->getRealPath().DIRECTORY_SEPARATOR.'openapi.json')) {
                $documentFile = 'openapi.json';
            } elseif (file_exists($dir->getRealPath().DIRECTORY_SEPARATOR.'openapi.yaml')) {
                $documentFile = 'openapi.yaml';
            } elseif (file_exists($dir->getRealPath().DIRECTORY_SEPARATOR.'openapi.yml')) {
                $documentFile = 'openapi.yml';
            } else {
                throw new \LogicException('Missing OpenApi 3 document in the example folder.');
            }

            $entityFinder = new Finder();
            $entityFinder->files()
                ->in($dir->getRealPath().DIRECTORY_SEPARATOR.'Entity')
                ->depth(0)
                ->ignoreDotFiles(true);

            $repoFinder = new Finder();
            $repoFinder->files()
                ->in($dir->getRealPath().DIRECTORY_SEPARATOR.'Repository')
                ->depth(0)
                ->ignoreDotFiles(true);

            yield [$dir->getFilename(), $documentFile, $entityFinder->getIterator(), $repoFinder->getIterator()];
        }
    }

    protected function setUp(): void
    {
        static::bootKernel();

        $application = new Application(static::$kernel);
        $application->setCatchExceptions(false);
        $application->setAutoExit(false);

        $this->tester = new ApplicationTester($application);
        $this->cleanSrcDirectory();
    }

    /**
     * @dataProvider dataExamples
     *
     * @param string $exampleDir
     * @param string $documentFile
     * @param \Iterator $expectedEntities
     *
     * @param \Iterator $expectedRepositories
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     * @throws DirectoryNotFoundException
     */
    public function testShouldCreateEntities(
        string $exampleDir,
        string $documentFile,
        \Iterator $expectedEntities,
        \Iterator $expectedRepositories
    ) {
        $this->tester->run(
            [
                'command' => 'make:api',
                '--path' => self::$entityPath,
                'openapi_doc_path' => self::$examplesPath.$exampleDir.\DIRECTORY_SEPARATOR.$documentFile,
            ]
        );

        $examples = [
            [
                'expected_files' => $expectedEntities,
                'generated_path' => self::$entityPath,
                'example_path' => self::$examplesPath.$exampleDir.\DIRECTORY_SEPARATOR.'Entity'.\DIRECTORY_SEPARATOR,
            ],
            [
                'expected_files' => $expectedRepositories,
                'generated_path' => self::$repoPath,
                'example_path' => self::$examplesPath.$exampleDir.\DIRECTORY_SEPARATOR.'Repository'.\DIRECTORY_SEPARATOR,
            ],
        ];

        foreach ($examples as $expected) {
            $finder = new Finder();
            $finder->files()
                ->in($expected['example_path'])
                ->depth(0);
            /** @var \AppendIterator $foundFiles */
            $foundFiles = $finder->getIterator();

            $this->assertEquals(\iterator_count($expected['expected_files']), \iterator_count($foundFiles));

            foreach ($expected['expected_files'] as $fileInfo) {
                $this->assertFileEquals(
                    $expected['example_path'].$fileInfo->getFilename(),
                    $expected['generated_path'].$fileInfo->getFilename()
                );
            }
        }
    }

    private function cleanSrcDirectory()
    {
        $filesystem = new Filesystem();
        $finder = new Finder();
        $allPath = [self::$entityPath, self::$repoPath];

        foreach ($allPath as $path) {
            $finder->files()->in($path);

            if ($finder->hasResults()) {
                /** @var SplFileInfo $file */
                foreach ($finder as $file) {
                    $filesystem->remove($file->getRealPath());
                }
            }
        }
    }
}