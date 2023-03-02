<?php

namespace app\models\Forms\Nomenclature;

use app\core\traits\Lists\GetRubricatorTrait;
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
    use GetRubricatorTrait; 
    
    public $id;
    
    public $parentId;

    public $name;
    
    public $nameEng;
        
    public function __construct(Rubricator $rubricator = null, $config = [])
    {
        parent::__construct($config);
        if ($rubricator) {
            //$this->order = $rubricator->parent;
            $this->name = $rubricator->name;
            $this->nameEng = $rubricator->nameEng;
            $this->parentId = $rubricator->parent ? $rubricator->parent->id: null;
            $this->id = $rubricator->id;
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['parentId'], 'integer'],
            [['name','nameEng'], 'string'],
            [['name','nameEng'], 'required'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app','Name'),
            'nameEng' => Yii::t('app','Name') . ' (ENG)',
            'parentId' => Yii::t('app','Parent section'),
            
        ];        
    }    
}
