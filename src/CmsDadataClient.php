<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 * @author Semenov Alexander <semenov@skeeks.com>
 */

namespace skeeks\cms\dadata;

use skeeks\yii2\dadataClient\DadataClient;

/**
 * @author Semenov Alexander <semenov@skeeks.com>
 */
class CmsDadataClient extends DadataClient
{
    public function init()
    {
        parent::init();

        if (\Yii::$app->dadataSettings->token) {
            $this->token = \Yii::$app->dadataSettings->token;
        }

        if (\Yii::$app->dadataSettings->secret) {
            $this->token = \Yii::$app->dadataSettings->secret;
        }
    }
}