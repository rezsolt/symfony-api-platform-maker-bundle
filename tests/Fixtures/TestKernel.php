<?php

namespace tests\Rezsolt\ApiPlatformMakerBundle\Fixtures;

use ApiPlatform\Core\Bridge\Symfony\Bundle\ApiPlatformBundle;
use Rezsolt\ApiPlatformMakerBundle\ApiPlatformMakerBundle;
use Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\MakerBundle\MakerBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

/**
 * Class TestKernel
 */
class TestKernel extends Kernel
{
    /**
     * Returns an array of bundles to register.
     *
     * @return iterable|BundleInterface[] An iterable of bundle instances
     */
    public function registerBundles()
    {
        return [
            new FrameworkBundle(),
            new SensioFrameworkExtraBundle(),
            new ApiPlatformBundle(),
            new MakerBundle(),
            new ApiPlatformMakerBundle(),
        ];
    }

    /**
     * Loads the container configuration.
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $kernelProjectDir = $this->getProjectDir();
        $loader->load(__DIR__.\DIRECTORY_SEPARATOR.'config.yaml');
        $loader->load($kernelProjectDir.\DIRECTORY_SEPARATOR.'vendor/symfony/framework-bundle/Resources/config/routing.xml');
        $loader->load($kernelProjectDir.\DIRECTORY_SEPARATOR.'src/Resources/config/server_generator.xml');
        $loader->load($kernelProjectDir.\DIRECTORY_SEPARATOR.'src/Resources/config/generator_command.xml');
    }

    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
        $routes->import(__DIR__.\DIRECTORY_SEPARATOR.'routes.yaml', '/test');
    }
}