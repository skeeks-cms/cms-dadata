<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 * @author Semenov Alexander <semenov@skeeks.com>
 */
namespace skeeks\cms\dadata;
use skeeks\cms\base\Component;
use skeeks\yii2\dadataSuggestApi\helpers\SuggestAddressModel;
use Yii;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/**
 * @author Semenov Alexander <semenov@skeeks.com>
 */
class CmsDadataSettings extends Component
{
    /**
     * @var string
     */
    public $token   = '';
    public $secret   = '';

    /**
     * @return array
     */
    static public function descriptorConfig() {
        return array_merge(parent::descriptorConfig(), [
            'name'          => \Yii::t('skeeks/dadata-suggest', 'Service tips dadata.ru'),
        ]);
    }


    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            ['token', 'string'],
            ['secret', 'string'],
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'token' => \Yii::t('skeeks/dadata-suggest', 'Authorization token'),
            'secret' => \Yii::t('skeeks/dadata-suggest', 'Authorization secret'),
        ]);
    }

    public function attributeHints()
    {
        return ArrayHelper::merge(parent::attributeHints(), [
            'token' => \Yii::t('skeeks/dadata-suggest', 'https://dadata.ru/api/'),
            'secret' => \Yii::t('skeeks/dadata-suggest', 'https://dadata.ru/api/'),
        ]);
    }

    public function getConfigFormFields()
    {
        return [
            'token',
            'secret'
        ];
    }




    /**
     * @var string
     */
    public $sessionName = 'datataSuggest';

    private $_address = null;

    /**
     * @return null|SuggestAddressModel
     */
    public function getAddress()
    {
        if ($this->_address !== null)
        {
            return $this->_address;
        }

        $dataFromSession = \Yii::$app->session->get($this->sessionName);
        if ($dataFromSession)
        {
            \Yii::info('Address from session', self::className());
            $this->_address = new SuggestAddressModel($dataFromSession);
            return $this->_address;
        }

        $response = \Yii::$app->dadataSuggestApi->detectAddressByIp(\Yii::$app->request->userIP);

        if ($response->isOk)
        {
            \Yii::info('Address from api', self::className());
            $data = ArrayHelper::getValue($response->data, 'location');
            $this->saveAddress($data);

            $this->_address = new SuggestAddressModel($data);

            return $this->_address;
        }

        return null;
    }

    /**
     * Сохранение определенных данных
     *
     * @param array $data данные полученные из api dadata
     * @return $this
     */
    public function saveAddress($data = [])
    {
        \Yii::$app->session->set($this->sessionName, $data);
        return $this;
    }

    /**
     * Адрес сохранен в сессии?
     * @return bool
     */
    public function getIsSavedAddress()
    {
        return \Yii::$app->session->has($this->sessionName);
    }
}