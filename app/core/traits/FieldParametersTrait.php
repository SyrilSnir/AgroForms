<?php

namespace app\core\traits;

use app\models\ActiveRecord\Forms\ElementType;
use app\models\ActiveRecord\Forms\Field;
use app\models\Forms\Manage\Forms\FieldParametersForm;
use app\models\Forms\Manage\Forms\Parameters\BadgesParameters;
use app\models\Forms\Manage\Forms\Parameters\BaseParametersForm;
use app\models\Forms\Manage\Forms\Parameters\FreeCountForm;
use app\models\Forms\Manage\Forms\Parameters\FrizeForm;
use app\models\Forms\Manage\Forms\Parameters\GroupFieldParametersForm;
use app\models\Forms\Manage\Forms\Parameters\HtmlBlockForm;
use app\models\Forms\Manage\Forms\Parameters\TextBlockForm;
use app\models\Forms\Requests\AttachedFilesForm;

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
            case ElementType::ELEMENT_INFORMATION_IMPORTANT:
                return new TextBlockForm($field);
            case ElementType::ELEMENT_INFORMATION:
                return new HtmlBlockForm($field);
            case ElementType::ELEMENT_FRIEZE:
                return new FrizeForm($field);
            case ElementType::ELEMENT_GROUP:
                return new GroupFieldParametersForm($field);
            case ElementType::ELEMENT_FILE:
            case ElementType::ELEMENT_FILE_MULTIPLE:
                return new \app\models\Forms\Manage\Forms\Parameters\AttachmentField($field);
            case ElementType::ELEMENT_ADDRESS_BLOCK:
            case ElementType::ELEMENT_IFORMATION_FORM:
                return new FreeCountForm($field);
            case ElementType::ELEMENT_BADGE:
                return new BadgesParameters($field);
            case ElementType::ELEMENT_RUBRICATOR:
                return new FreeCountForm($field);
            default:
                return new FieldParametersForm($field);
        }
    }    
}
