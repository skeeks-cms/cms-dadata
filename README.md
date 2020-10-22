Dadata suggest for SkeekS CMS
===================================

Info
------------
* https://github.com/skeeks-semenov/yii2-dadata-suggest-api
* https://dadata.ru/api/suggest/

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist skeeks/cms-dadata-suggest "*"
```

or add

```
"skeeks/cms-dadata-suggest": "*"
```

Configuration app
----------

```php

'components' =>
[
    'dadataSuggest' => [
        'class'             => 'skeeks\cms\dadataSuggest\CmsDadataSuggestComponent',
    ],
    'dadataSuggestApi' => [
        'class'             => 'skeeks\cms\dadataSuggest\CmsDadataSuggestApi',
    ],
    'i18n' => [
        'translations' =>
        [
            'skeeks/dadata-suggest' => [
                'class'             => 'yii\i18n\PhpMessageSource',
                'basePath'          => '@skeeks/cms/dadataSuggest/messages',
                'fileMap' => [
                    'skeeks/dadata-suggest' => 'main.php',
                ],
            ]
        ]
    ]
],
'modules' =>
[
    'dadataSuggest' => [
        'class'         => 'skeeks\cms\dadataSuggest\CmsDadataSuggestModule',
    ]
]

```


Examples
----------

### First detect address from api and save to session

```php
\Yii::$app->dadataSuggest->address
```

### First detect address from api and save to session

```php
if (\Yii::$app->dadataSuggest->isSavedAddress)
{
    echo \Yii::$app->dadataSuggest->address->unrestrictedValue;
} else
{
    echo "Not saved address to session";
}
```


### Address widget

```php
<?= \skeeks\cms\dadataSuggest\widgets\address\DadataGetAddressWidget::widget([
    'options' =>
    [
        'href' => '#',
        'onclick' => 'new sx.classes.ModalRegionPageReload(); return false;',
        'class' => 'sx-dadata-suggestion-city',
    ]
]); ?>
```


### Suggest widget
```php
<?= \skeeks\cms\dadataSuggest\widgets\suggest\DadataSuggestInputWidget::widget([
    'name' => 'address',
    'id' => 'sx-global-region-input',
    'addon' => 'clear',
    'value' => \Yii::$app->dadataSuggest->isSavedAddress ? \Yii::$app->dadataSuggest->address->unrestrictedValue : "",
    'clientOptions' => [
        'onInit' => new \yii\web\JsExpression(<<<JS
            function(e, data)
            {
                data.DadataSuggest.bind('onSelect', function()
                {
                    $("#sx-save-region").show();
                });
            }
JS
        )
    ],

    'options' =>
    [
        'class'         => 'form-control',
        'placeholder'   => 'Найти город',
    ]
]); ?>
```

### Suggest widgets in forms
```php
<?= $form->field($model, 'post_recipient')->widget(
    \skeeks\cms\dadataSuggest\widgets\suggest\DadataSuggestInputWidget::className(),
    [
        'options' =>
        [
            'placeholder' => $model->getAttributeLabel('post_recipient'),
        ],

        'type' => 'NAME'
    ]
);
?>

### Suggest widgets with additional settings
```php

$form->field($model, 'post_address')->widget(
    \skeeks\cms\dadataSuggest\widgets\suggest\DadataSuggestInputWidget::className(),
    [
        'options' =>
        [
            'placeholder' => "Адрес (улица, дом, кв)",
        ],

        'clientOptions' =>
        [
            'suggestOptions' =>
            [
                'triggerSelectOnSpace' => true,
                'triggerSelectOnBlur' => true,

                'constraints' => [
                    [
                        'locations' => \Yii::$app->dadataSuggest->address->getRegionArray(),

                        'deletable' => false,
                        'label'     => ''
                    ]
                ],
                'restrict_value' => true,
            ],
            'onInit' => new \yii\web\JsExpression(<<<JS
                function(e, data)
                {
                    data.DadataSuggest.bind('onSelect', function()
                    {
                        data.DadataSuggest.bind('afterSave', function()
                        {
                            $.pjax.reload({container:'#sx-cart-full'});
                        });

                        data.DadataSuggest.save();
                        return false;
                    });
                }
JS
            )

        ]
    ]);
?>
```

##Links
* [Web site](http://en.cms.skeeks.com)
* [Web site (rus)](http://cms.skeeks.com)
* [Author](http://skeeks.com)
* [ChangeLog](https://github.com/skeeks-cms/cms-dadata-suggest/blob/master/CHANGELOG.md)



___

> [![skeeks!](https://skeeks.com/img/logo/logo-no-title-80px.png)](https://skeeks.com)  
<i>SkeekS CMS (Yii2) — fast, simple, effective!</i>  
[skeeks.com](https://skeeks.com) | [cms.skeeks.com](https://cms.skeeks.com)
