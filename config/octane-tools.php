<?php

return [
    'timeout' => 60 * 5,
    'phpmd' => [
        'command' => base_path('vendor/phpmd/phpmd/src/bin/phpmd'),
        'dirs' => ['app', 'routes'],
        'exclude' => ['database/seeds', 'database', 'config'],
        'config-file' => __DIR__.'/phpmd.xml',
    ],
];
