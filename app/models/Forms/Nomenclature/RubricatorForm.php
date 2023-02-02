<?php

namespace app\models\Forms\Nomenclature;

use app\models\ActiveRecord\Nomenclature\Rubricator;
use app\models\Forms\Manage\ManageForm;
use Yii;

/**
 * Description of RubricatorForm
 *
 * @author kotov
 */
class RubricatorForm extends ManageForm
{
    public $id;
    
    public $order;
    
    public $name;
    
    public $nameEng;
    
    public function __construct(Rubricator $rubricator = null, $config = [])
    {
        parent::__construct($config);
        if ($rubricator) {
            $this->order = $rubricator->order;
            $this->name = $rubricator->name;
            $this->nameEng = $rubricator->nameEng;
            $this->id = $rubricator->id;
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['order'], 'integer'],
            [['name','nameEng'], 'string'],
            [['name'], 'required'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app','Name'),
            'nameEng' => Yii::t('app','Name') . ' (ENG)',
            'order' => Yii::t('app','Serial number'),
        ];        
    }     
}
