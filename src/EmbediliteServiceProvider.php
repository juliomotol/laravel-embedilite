<?php

namespace JulioMotol\Embedilite;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class EmbediliteServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('embedilite')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel_embedilite_table');
    }
}
