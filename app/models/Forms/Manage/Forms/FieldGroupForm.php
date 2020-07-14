<?php

namespace app\models\Forms\Manage\Forms;

use app\models\ActiveRecord\Forms\FieldGroup;
use yii\base\Model;

/**
 * Description of FieldGroupForm
 *
 * @author kotov
 */
class FieldGroupForm extends Model
{
    
    public $name;
    public $nameEng;
    public $description;
    public $descriptionEng;
    public $order;
    
    public function __construct(FieldGroup $model = null, $config = array())
    {
        if ($model) {
            $this->name = $model->name;
            $this->nameEng = $model->name_eng;
            $this->description = $model->description;
            $this->descriptionEng = $model->description_eng;
            $this->order = $model->order;
                    
        }
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'nameEng'], 'required'],
            [['order'], 'integer'],
            [['order'], 'default', 'value' => 0],
            [['name', 'description', 'nameEng', 'descriptionEng'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название группы полей',
            'description' => 'Описание',
            'nameEng' => 'Название группы полей (ENG)',
            'descriptionEng' => 'Описание (ENG)',
            'order' => 'Порядок вывода',
        ];
    }    
}
