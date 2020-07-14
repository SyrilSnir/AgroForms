<?php

namespace app\core\repositories\readModels;

use yii\db\ActiveRecord;
/**
 *
 * @author kotov
 */
interface ReadRepositoryInterface
{
    /**
     * 
     * @param int $id
     * @return ActiveRecord|null
     */
    public static function findById($id);

}
