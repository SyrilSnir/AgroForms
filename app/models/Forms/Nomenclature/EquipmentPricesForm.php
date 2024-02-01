<?php

namespace app\models\Forms\Nomenclature;

use app\models\ActiveRecord\Exhibition\Exhibition;
use app\models\ActiveRecord\Nomenclature\Equipment;
use app\models\ActiveRecord\Nomenclature\EquipmentPrices;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use ZipStream\Test\TimeTest;

/**
 * Description of EquipmentPricesForm
 *
 * @author kotov
 */
class EquipmentPricesForm extends Model
{
    public $exhibitionId;
    
    public $equipmentId;
    
    public $price;
    
    public function __construct(EquipmentPrices $model = null, $config = [])
    {
        if ($model) {
            $this->equipmentId = $model->equipment_id;
            $this->exhibitionId = $model->exhibition_id;
            $this->price = $model->price;
        }
        parent::__construct($config);        
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['exhibitionId', 'equipmentId', 'price'], 'required'],
            [['exhibitionId', 'equipmentId', 'price'], 'integer'],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'exhibitionId' => t('Exhibition'),
            'equipmentId' => t('Add. equipment'),
            'price' => t('Price'),
        ];
    }
    
    public function getExhibitionsList()
    {  
        /** @var Equipment $nomenclatureModel */
        //$nomenclatureModel = Equipment::findOne($this->equipmentId);
        $filter = ArrayHelper::getColumn(EquipmentPrices::find()->andWhere(['deleted' => false])->andWhere(['equipment_id' => $this->equipmentId])->asArray()->all(),'exhibition_id');
        
        $query = Exhibition::find()->orderBy('id');
        if (!empty($filter)) {
            $query->andFilterWhere(['NOT IN', 'id', $filter]);
        }
        $result = ArrayHelper::map($query->asArray()->all(), 'id', 'title');
        return $result;
    }    
}
