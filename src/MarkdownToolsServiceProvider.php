<?php

namespace Cassarco\MarkdownTools;

use Cassarco\MarkdownTools\Commands\MarkdownToolsCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class MarkdownToolsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('markdown-tools')
            ->hasConfigFile()
            ->hasCommand(MarkdownToolsCommand::class)
            ->hasInstallCommand(function ($command) {
                $command
                    ->publishConfigFile()
                    ->publish('actions')
                    ->askToStarRepoOnGitHub('cassarco/markdown-tools');
            });
    }

    public function packageBooted(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../stubs/MarkdownFileHandler.php.stub' => app_path('Actions/MarkdownFileHandler.php'),
                __DIR__.'/../stubs/MarkdownFileRules.php.stub' => app_path('Actions/MarkdownFileRules.php'),
            ], "{$this->package->shortName()}-actions");
        }
    }
}
