<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\Forms\Manage\Forms;

use app\models\ActiveRecord\Forms\SpecialPrice;
use DateTime;
use yii\base\Model;

/**
 * Description of SpecialPriceForm
 *
 * @author kotov
 */
class SpecialPriceForm extends Model
{
    public $id; 
    
    public $startDate;
    
    public $endDate;
    
    public $price;
    
    public $fieldId;


    public function __construct(SpecialPrice $model = null, $config = [])
    {
        if($model) {
            $this->id = $model->id;                    
            $this->price = $model->price;
            $this->fieldId = $model->field_id;
            $this->startDate = DateTime::createFromFormat('Y-m-d',$model->start_date)->format('d.m.Y');
            $this->endDate = DateTime::createFromFormat('Y-m-d',$model->end_date)->format('d.m.Y');
        }
        parent::__construct($config);
    }
    
    public function rules():array 
    {
        return [
            [['price','fieldId'],'integer'],
            [['price','fieldId','startDate','endDate'],'required'],
            [['startDate','endDate'],'safe'],
            [['startDate'],'validateDate'],
        ];
    }
    
    public function attributeLabels(): array    
    {
        return [
            'price' => t('Price'),
            'startDate' => t('Start date'),
            'endDate' => t('End date')
        ];
    }
    public function validateDate($attribute,$param)
    {
        /** @var SpecialPrice $price */
        $startDate = DateTime::createFromFormat('d.m.Y', $this->startDate)->getTimestamp();
        $endDate = DateTime::createFromFormat('d.m.Y', $this->endDate)->getTimestamp();
        if (($endDate - $startDate) < 0) {
            $this->addError($attribute, t('Wrong period'));
            return;
        }
        $listOfPrices = SpecialPrice::find()
                ->andFilterWhere(['field_id' => $this->fieldId])
                ->andFilterWhere(['!=','id', $this->id])
                ->all();
        foreach ($listOfPrices as $price) {
            if ($startDate > $price->endDateTimestamp || $endDate < $price->startDateTimestamp) {
                continue;
            }
            $this->addError($attribute, t('Date intervals must not overlap'));             
        }
    }
}