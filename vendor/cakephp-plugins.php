<?php
$baseDir = dirname(dirname(__FILE__));
return [
    'plugins' => [
        'Altair' => $baseDir . '/vendor/tutida/altair/',
        'Bake' => $baseDir . '/vendor/cakephp/bake/',
        'BootstrapUI' => $baseDir . '/vendor/friendsofcake/bootstrap-ui/',
        'Cake/Localized' => $baseDir . '/vendor/cakephp/localized/',
        'DebugKit' => $baseDir . '/vendor/cakephp/debug_kit/',
        'Migrations' => $baseDir . '/vendor/cakephp/migrations/',
        'Partial' => $baseDir . '/vendor/kozo/partial/',
        'Search' => $baseDir . '/vendor/friendsofcake/search/'
    ]
];