<?php

namespace app\models\Forms\Manage\Users;

use app\models\ActiveRecord\Users\UserType;
use Yii;
use yii\base\Model;

/**
 * Description of UserTypeForm
 *
 * @author kotov
 */
class UserTypeForm extends Model
{
    /**
     *
     * @var string
     */
    public $name;
    /**
     *
     * @var string
     */
    public $nameEng;    
      
    public function __construct(UserType $model = null, $config = array())
    {
        if ($model) {
            $this->name = $model->name;
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
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app','Role'),
            'nameEng' => Yii::t('app','Role') . ' (ENG)',
        ];
    }
}
