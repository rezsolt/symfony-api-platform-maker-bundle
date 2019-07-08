<?php

declare(strict_types=1);

namespace Rezsolt\ApiPlatformMakerBundle\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\ApplicationTester;
use Symfony\Component\Filesystem\Filesystem;
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

    public static function setUpBeforeClass():void
    {
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

    protected function setUp():void
    {
        static::bootKernel();

        $application = new Application(static::$kernel);
        $application->setCatchExceptions(false);
        $application->setAutoExit(false);

        $this->tester = new ApplicationTester($application);
        $this->cleanSrcDirectory();
    }

    public function testShouldCreateEntities()
    {
        $this->tester->run(
            [
                'command' => 'make:api',
                '--path' => self::$entityPath,
                'openapi_doc_path' => self::$examplesPath.'entities_001'.\DIRECTORY_SEPARATOR.'openapi.json'
            ]
        );

        $this->assertFileExists(self::$entityPath.'FirstFoo.php');
        $this->assertFileExists(self::$entityPath.'SecondBar.php');
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