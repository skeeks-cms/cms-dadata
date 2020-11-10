<?php
return [

    'components' => [

        'dadataSettings' => [
            'class'             => \skeeks\cms\dadata\CmsDadataSettings::class
        ],

        'dadataClient' => [
            'class'             => \skeeks\cms\dadata\CmsDadataClient::class,
        ],

        'i18n' => [
            'translations' => [
                'skeeks/cms-dadata' => [
                    'class'             => 'yii\i18n\PhpMessageSource',
                    'basePath'          => '@skeeks/cms/dadata/messages',
                    'fileMap' => [
                        'skeeks/cms-dadata' => 'main.php',
                    ],
                ]
            ]
        ]
    ],
];