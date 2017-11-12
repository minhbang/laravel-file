<?php namespace Minhbang\File\Tests\Stubs;
/**
 * Class IntergrationTestCase
 * @package Minhbang\Enum\Tests\Stubs
 * @author Minh Bang
 */
class IntergrationTestCase extends \Minhbang\Kit\Testing\IntegrationTestCase
{
    /**
     * @param  \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return array_merge(
            parent::getPackageProviders($app),
            [
                \Minhbang\File\ServiceProvider::class,
            ]
        );
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);
        $app->bind('path.public', function () {
            return __DIR__ . '/public';
        });
    }
}