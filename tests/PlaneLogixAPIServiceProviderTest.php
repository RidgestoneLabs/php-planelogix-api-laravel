<?php

namespace PlaneLogixAPI\Laravel\Test;

use Illuminate\Container\Container;
use PHPUnit\Framework\TestCase;
use PlaneLogixAPI\Laravel\PlaneLogixAPIServiceProvider;

abstract class PlaneLogixAPIServiceProviderTest extends TestCase
{
    public function testServiceNameIsProvided()
    {
        $app = $this->setupApplication();
        $provider = $this->setupServiceProvider($app);
        $this->assertContains('planelogix', $provider->provides());
    }

    public function testVersionInformationIsProvidedToSdkUserAgent()
    {
        $app = $this->setupApplication();
        $this->setupServiceProvider($app);
        $config = $app['config']->get('planelogix');

        $this->assertArrayHasKey('ua_append', $config);
        $this->assertIsArray($config['ua_append']);
        $this->assertNotEmpty($config['ua_append']);
        $this->assertNotEmpty(
            array_filter($config['ua_append'], function ($userAgent) {
                return str_contains($userAgent, PlaneLogixAPIServiceProvider::VERSION);
            })
        );
    }

    /**
     * @return Container
     */
    abstract protected function setupApplication();

    /**
     * @param Container $app
     *
     * @return PlaneLogixAPIServiceProvider
     */
    private function setupServiceProvider(Container $app)
    {
        // Create and register the provider.
        $provider = new PlaneLogixAPIServiceProvider($app);
        $app->register($provider);
        $provider->boot();

        return $provider;
    }
}
