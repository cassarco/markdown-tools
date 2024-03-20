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
            ->hasCommand(MarkdownToolsCommand::class);
    }
}
