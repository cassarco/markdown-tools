<?php

namespace Carlcassar\Lark;

use Carlcassar\Lark\Commands\LarkCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LarkServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('lark')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_lark_table')
            ->hasCommand(LarkCommand::class);
    }
}
