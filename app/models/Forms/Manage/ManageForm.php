<?php

namespace app\models\Forms\Manage;

use yii\base\Model;

/**
 * Description of ManageForm
 *
 * @author kotov
 */
abstract class ManageForm extends Model
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    
    public static function createWithModel(Model $model)
    {
        return new static($model);
    }
    
    public function scenarios(): array
    {
         $scenarios = parent::scenarios();
         $scenarios[self::SCENARIO_CREATE] = $scenarios[Model::SCENARIO_DEFAULT];
         $scenarios[self::SCENARIO_UPDATE] = $scenarios[Model::SCENARIO_DEFAULT];
         return $scenarios;
    }
}
