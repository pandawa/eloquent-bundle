<?php

declare(strict_types=1);

namespace Pandawa\Bundle\EloquentBundle;

use Faker\Factory as FakerFactory;
use Faker\Generator as FakerGenerator;
use Illuminate\Database\Eloquent\Model;
use Pandawa\Component\Foundation\Bundle\Bundle;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
class EloquentBundle extends Bundle
{
    /**
     * The array of resolved Faker instances.
     *
     * @var array
     */
    protected static array $fakers = [];

    public function boot(): void
    {
        Model::setConnectionResolver($this->app['db']);
        Model::setEventDispatcher($this->app['events']);
    }

    public function register(): void
    {
        Model::clearBootedModels();

        $this->registerEloquentFactory();
    }

    protected function registerEloquentFactory(): void
    {
        $this->app->singleton(FakerGenerator::class, function ($app, $parameters) {
            $locale = $parameters['locale'] ?? $app['config']->get('app.faker_locale', 'en_US');

            if (!isset(static::$fakers[$locale])) {
                static::$fakers[$locale] = FakerFactory::create($locale);
            }

            static::$fakers[$locale]->unique(true);

            return static::$fakers[$locale];
        });
    }
}
