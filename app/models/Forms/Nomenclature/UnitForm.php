<?php

namespace app\models\Forms\Nomenclature;

use app\models\ActiveRecord\Nomenclature\Unit;
use yii\base\Model;

/**
 * Description of UnitForm
 *
 * @author kotov
 */
class UnitForm extends Model
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
    public $shortName;
    
    /**
     *
     * @var string
     */
    public $nameEng;
    
    /**
     *
     * @var string
     */
    public $shortNameEng;    
    
    public function __construct(Unit $model = null, $config = array())
    {
        if ($model) {
            $this->name = $model->name;
            $this->shortName = $model->short_name;
            $this->nameEng = $model->name_eng;
            $this->shortNameEng = $model->short_name_eng;
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
            [['name', 'shortName','nameEng', 'shortNameEng'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'shortName' => 'Краткое наименование',
            'nameEng' => 'Наименование (ENG)',
            'shortNameEng' => 'Краткое наименование (ENG)',            
        ];
    }
}
