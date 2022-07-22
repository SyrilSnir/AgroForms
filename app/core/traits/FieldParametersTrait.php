<?php

namespace app\core\traits;

use app\models\ActiveRecord\Forms\ElementType;
use app\models\ActiveRecord\Forms\Field;
use app\models\Forms\Manage\Forms\FieldParametersForm;
use app\models\Forms\Manage\Forms\Parameters\BaseParametersForm;
use app\models\Forms\Manage\Forms\Parameters\FrizeForm;
use app\models\Forms\Manage\Forms\Parameters\GroupFieldParametersForm;
use app\models\Forms\Manage\Forms\Parameters\HtmlBlockForm;
use app\models\Forms\Manage\Forms\Parameters\TextBlockForm;

/**
 *
 * @author kotov
 */
trait FieldParametersTrait
{
    /**
     * 
     * @param int $elementTypeId
     * @return BaseParametersForm
     */
    public function getParametersForm(int $elementTypeId, Field $field = null): BaseParametersForm
    {
        switch ($elementTypeId) {
            case ElementType::ELEMENT_HEADER:
                return new TextBlockForm($field);
            case ElementType::ELEMENT_INFORMATION:
            case ElementType::ELEMENT_INFORMATION_IMPORTANT:
                return new HtmlBlockForm($field);
            case ElementType::ELEMENT_FRIEZE:
                return new FrizeForm($field);
            case ElementType::ELEMENT_GROUP:
                return new GroupFieldParametersForm($field);
            default:
                return new FieldParametersForm($field);
        }
    }    
}
