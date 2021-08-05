<?php

namespace app\models\Forms\Manage\Forms;

use app\models\ActiveRecord\Forms\ElementType;
use Yii;
use yii\base\Model;

/**
 * Description of ElementTypeForm
 *
 * @author kotov
 */
class ElementTypeForm extends Model
{
    public $name;
    public $description;
    
    public function __construct(
            ElementType $model = null,
            $config = array()
            )
    {
        parent::__construct($config);
        if ($model) {
            $this->name = $model->name;
            $this->description = $model->description;
        }
    }
 
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('app','Name'),
            'description' => Yii::t('app','Description'),
        ];
    }    
}
