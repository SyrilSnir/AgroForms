<?php

namespace app\models\Forms\Nomenclature;

use app\models\ActiveRecord\Nomenclature\EquipmentGroup;
use Yii;
use yii\base\Model;
/**
 * Description of CategoryForm
 *
 * @author kotov
 */
class EquipmentGroupForm extends Model
{
    public $name;
    public $description;
    
    public $nameEng;
    public $descriptionEng;
    
    public function __construct(EquipmentGroup $model = null, $config = array())
    {
        if ($model) {
            $this->name = $model->name;
            $this->description = $model->description;
            $this->nameEng = $model->name_eng;
            $this->descriptionEng = $model->description_eng;
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
            [['name', 'description','nameEng','descriptionEng'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('app','Category'),
            'description' => Yii::t('app','Description'),
            'nameEng' => Yii::t('app','Category') . ' (ENG)',
            'descriptionEng' => Yii::t('app','Description') . ' (ENG)',            
        ];
    }
}
