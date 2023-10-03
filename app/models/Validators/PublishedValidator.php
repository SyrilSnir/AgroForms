<?php

namespace app\models\Validators;

use app\models\ActiveRecord\Forms\Form;
use app\models\Forms\Manage\Forms\FormsForm;
use yii\validators\Validator;

/**
 * Description of PublishedValidator
 *
 * @author kotov
 */
class PublishedValidator extends Validator
{
    public function validateAttribute($model, $attribute) 
    {
        /** @var FormsForm $model */
        if (!property_exists($model, 'published')) {
            $this->addError($model, $attribute, 'Данный валидатор поддерживается только объектом Form');
            return ;
        }
        if ($attribute != 'published') {
            $this->addError($model, $attribute, 'Данный валидатор может быть установлен только на идентификатор "Опубликован на сайте"');
            return ;            
        }
        if (!$model->published) {
            return;
        }
        $formsToPublic = Form::find()
                ->andWhere(['exhibition_id' => $model->exhibitionId])
                ->andWhere(['published' => true]);
        if ($model->id) {
            $formsToPublic->andWhere(['!=','id',$model->id ]);
        }        
        if ($formsToPublic->count() > 0) {
            $this->addError($model, $attribute, 'Для одной выставки не может быть более одной формы доступной для публикации');
        }
    }
}
