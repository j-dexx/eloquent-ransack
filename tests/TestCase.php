<?php

namespace Jdexx\EloquentRansack\Tests;

use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->withFactories(__DIR__ . '/Support/database/factories');

        $this->loadMigrationsFrom(
            __DIR__ . '/Support/database/migrations'
        );
        $this->artisan('migrate', ['--database' => 'eloquent-ransack']);
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'eloquent-ransack');
        $app['config']->set('database.connections.eloquent-ransack', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }
}
