<?php

declare(strict_types=1);

namespace Rezsolt\ApiPlatformMakerBundle\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\ApplicationTester;

final class EntityCreationTest extends KernelTestCase
{
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

    public static function setUpBeforeClass()
    {
        $testPath = realpath(__DIR__.\DIRECTORY_SEPARATOR.'..').\DIRECTORY_SEPARATOR;
        self::$srcPath = $testPath.'temp_src'.\DIRECTORY_SEPARATOR;
        self::$entityPath = self::$srcPath.'Entity'.\DIRECTORY_SEPARATOR;
        self::$examplesPath = $testPath.'Fixtures'.\DIRECTORY_SEPARATOR.'examples'.\DIRECTORY_SEPARATOR;
    }

    protected function setUp()
    {
        static::bootKernel();

        $application = new Application(static::$kernel);
        $application->setCatchExceptions(false);
        $application->setAutoExit(false);

        $this->tester = new ApplicationTester($application);
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
}