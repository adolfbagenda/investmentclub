<?php

namespace adolfbagenda\InvestmentClub\Tests;

use adolfbagenda\InvestmentClub\InvestmentClubBaseServiceProvider;
use Route;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Route::auth();
        $this->loadLaravelMigrations();
        $this->loadMigrationsFrom(__DIR__.'/../database/test_migrations');
        /*$this->artisan('migrate',[
          '--database' => 'testdb',
          '--realpath' => realpath(__DIR__.'/../database/test_migrations'),
        ])->run();*/
        $this->withFactories(__DIR__.'/../database/factories');
        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();
    }

    protected function getPackageProviders($app)
    {
        return InvestmentClubBaseServiceProvider::class;
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.key', 'base64:7cTani6npGETrhDkHpBxFjD1gztdumNrLkJAShMg+zI=');
        $app['config']->set('database.default', 'testdb');
        $app['config']->set('database.connections.testdb', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
        ]);
        $app['config']->set('auth.providers', [
          'users' => [
            'driver' => 'eloquent',
            'model'  => adolfbagenda\InvestmentClub\User::class,
          ],

        ]);
        $app['config']->set('auth.defaults', [
          'guard'     => 'web',
          'passwords' => 'users',

        ]);

        /*$app['config']->set('bustravel',[
          'user_model' => '\glorifiedking\BusTravel\User::class',
          'path' => 'transit',

        ]);*/
    }
}
