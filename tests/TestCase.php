<?php

namespace Cassarco\MarkdownTools\Tests;

use Cassarco\MarkdownTools\MarkdownTools;
use Cassarco\MarkdownTools\MarkdownToolsServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public MarkdownTools $markdownTools;

    public function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_markdown-tools_table.php.stub';
        $migration->up();
        */
    }

    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName
            ) => 'Cassarco\\MarkdownTools\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app): array
    {
        return [
            MarkdownToolsServiceProvider::class,
        ];
    }
}
