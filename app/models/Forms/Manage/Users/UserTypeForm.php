<?php

namespace app\models\Forms\Manage\Users;

use app\models\ActiveRecord\Users\UserType;
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
      
    public function __construct(UserType $model = null, $config = array())
    {
        if ($model) {
            $this->name = $model->name;
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
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Наименование',
        ];
    }
}
