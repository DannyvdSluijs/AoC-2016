<?php

use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
    ])
    ->withSets([SetList::PHP_83, SetList::CODING_STYLE])
    ->withPreparedSets(codeQuality: true, deadCode: true, earlyReturn: true)
    ->withRules([InlineConstructorDefaultToPropertyRector::class]);
