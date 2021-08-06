<?php

namespace app\models\Forms\Geography;

use app\models\ActiveRecord\Geography\Country;
use Yii;
use yii\base\Model;


/**
 * Description of CountryForm
 *
 * @author kotov
 */
class CountryForm extends Model
{
    public $name;
    public $nameEng;
    public $code;
    
    public function __construct(Country $model = null, $config = array())
    {
        if ($model) {
            $this->name = $model->name;
            $this->code = $model->code;
            $this->nameEng = $model->name_eng;
        }
        parent::__construct($config);
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name','nameEng'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('app', 'Country'),
            'nameEng' => Yii::t('app', 'Country') . ' (ENG)',
            'code' => Yii::t('app', 'Identifier'),
        ];
    }
}
