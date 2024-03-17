<?php

namespace Cassarco\Lark;

use Cassarco\Lark\Commands\LarkCommand;
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
            ->hasCommand(LarkCommand::class);
    }
}
