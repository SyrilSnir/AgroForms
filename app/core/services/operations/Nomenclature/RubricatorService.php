<?php

namespace app\core\services\operations\Nomenclature;

use app\core\services\operations\DataManqageInterface;
use app\models\Forms\Manage\ManageForm;
use yii\db\ActiveRecord;

/**
 * Description of RubricatorService
 *
 * @author kotov
 */
class RubricatorService implements DataManqageInterface
{
    public function create(ManageForm $form): ActiveRecord
    {
        
    }

    public function edit(int $id, ManageForm $form): void
    {
        
    }

    public function remove(int $id): void
    {
        
    }

}
