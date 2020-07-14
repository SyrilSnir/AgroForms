<?php

namespace app\models\Forms\Nomenclature;

use app\models\ActiveRecord\Nomenclature\Equipment;
use app\models\ActiveRecord\Nomenclature\EquipmentGroup;
use app\models\ActiveRecord\Nomenclature\Unit;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Description of EquipmentForm
 *
 * @author kotov
 */
class EquipmentForm extends Model
{
    public $name;
    public $code;
    public $description;
    public $unitId;
    public $price;
    public $groupId;
    
    public $nameEng;
    public $descriptionEng;


    public function __construct(Equipment $model = null, $config = array())
    {
        if ($model) {
            $this->name = $model->name;
            $this->code = $model->code;
            $this->groupId = $model->group_id;
            $this->unitId = $model->unit_id;
            $this->price = $model->price;
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
            [['groupId', 'unitId', 'price'], 'integer'],
            [['name', 'unitId', 'price'], 'required'],
            [['description'], 'string'],
            [['code', 'name','nameEng','descriptionEng'], 'string', 'max' => 255],
            [['unitId'], 'exist', 'skipOnError' => true, 'targetClass' => Unit::className(), 'targetAttribute' => ['unitId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'groupId' => 'Группа оборудования',
            'code' => 'Код',
            'name' => 'Наименование',
            'description' => 'Описание',
            'unitId' => 'Единица измерения',
            'price' => 'Стоимость',
            'nameEng' => 'Наименование (ENG)',
            'descriptionEng' => 'Описание (ENG)',             
        ];
    }
    
    public function categoriesList()
    {
        return ArrayHelper::map(EquipmentGroup::find()->orderBy('id')->asArray()->all(), 'id', 'name');
    }    
    public function unitsList()
    {
        return ArrayHelper::map(Unit::find()->orderBy('id')->asArray()->all(), 'id', 'name');
    }    
}
