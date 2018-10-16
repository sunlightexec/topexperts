<?php
return [
    'translations' => [
        'app*' => [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@app/messages',
            'sourceLanguage' => 'en-US',
            'fileMap' => [
                'app' => 'app.php',
                'app/error' => 'error.php',
                'app/project_synonims' => 'project_synonims.php',
                'app/experts' => 'experts.php',
                'app/categories' => 'categories.php',
                'app/currencies' => 'currencies.php',
                'app/projects' => 'projects.php',
                'app/exceptions' => 'exceptions.php',
                'app/hystirical-data' => 'hystirical-data.php',
                'app/graduation-ratings' => 'graduation-ratings.php',
            ],
        ],
    ],
];