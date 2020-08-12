<?php

namespace app\core\services\operations\Forms;

use app\models\ActiveRecord\Forms\FormExhibitions;

/**
 * Description of FormExhibitionService
 *
 * @author kotov
 */
class FormExhibitionService
{
    public function setExhibitions(int $formId, array $exhibitionsList)
    {
        $this->clearExhibitions($formId);
        if (empty($exhibitionsList)) {
            return;
        }
        foreach ($exhibitionsList as $exhibitionId) {
            $model = FormExhibitions::create($formId, $exhibitionId);
            $model->save();
        }
    }


    public function clearExhibitions($formId)
    {
        FormExhibitions::deleteAll([
            'forms_id' => $formId
        ]);
    }
}
