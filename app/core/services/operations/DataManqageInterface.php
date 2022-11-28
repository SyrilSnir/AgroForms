<?php

namespace app\core\services\operations;

use app\models\Forms\Manage\ManageForm;
use yii\db\ActiveRecord;

/**
 * Description of DataManqageInterface
 *
 * @author kotov
 */
interface DataManqageInterface
{
   public function create(ManageForm $form): ActiveRecord;
   
   public function edit(int $id, ManageForm $form): void;
   
   public function remove(int $id): void;
   
}
