<?php

use Pandawa\Bundle\EloquentBundle\Annotation\RepositoryLoadHandler;
use Pandawa\Component\Eloquent;

return [
    'persistent' => [
        'class'       => Eloquent\Persistent\DatabasePersistent::class,
        'middlewares' => [
            Eloquent\Persistent\Middleware\DispatchEvent::class,
            Eloquent\Persistent\Middleware\InvalidateCache::class,
            Eloquent\Persistent\Middleware\DatabaseTransaction::class,
        ],
    ],

    'factory' => [
        'cache'         => Eloquent\Factory\CacheHandlerFactory::class,
        'query_builder' => Eloquent\Factory\QueryBuilderFactory::class,
        'repository'    => Eloquent\Factory\RepositoryFactory::class,
    ],

    'cache' => [
        'enabled' => env('ELOQUENT_CACHE', false),
        'store'   => env('ELOQUENT_CACHE_STORE', 'redis'),
        'ttl'     => env('ELOQUENT_CACHE_TTL', 60 * 60 * 24),
        'handler' => Eloquent\CacheHandler::class,
    ],

    'annotation' => [
        'handler' => RepositoryLoadHandler::class,
    ]
];
