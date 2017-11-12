<?php namespace Minhbang\File\Tests\Stubs;
/**
 * Class TestCase
 * @package Minhbang\File\Tests\Stubs
 * @author Minh Bang
 */
class TestCase extends \Minhbang\Kit\Testing\TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->loadMigrationsFrom([
            '--database' => 'testing',
            '--realpath' => realpath(__DIR__ . '/../migrations'),
        ]);
    }

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
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);
        $app->bind('path.public', function () {
            return __DIR__ . '/public';
        });
        $app['config']->set('filesystems.disks.data', [
            'driver' => 'local',
            'root' => __DIR__ . '/data',
        ]);
        $app['config']->set('filesystems.disks.upload', [
            'driver' => 'local',
            'root' => __DIR__ . '/public/upload',
        ]);
    }

}