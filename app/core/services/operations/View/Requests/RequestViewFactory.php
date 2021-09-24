<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\core\services\operations\View\Requests;

use app\models\ActiveRecord\Forms\FormType;
use app\models\ActiveRecord\Requests\Request;
use Yii;

/**
 * Description of RequestViewFactory
 *
 * @author kotov
 */
class RequestViewFactory
{
    public static function getViewService(Request $request): RequestViewInterface
    {
        switch ($request->type_id) {
            case FormType::SPECIAL_STAND_FORM:
                return Yii::$container->get(RequestStandViewService::class);
            case FormType::DYNAMIC_ORDER_FORM:
            case FormType::DYNAMIC_INFORMATION_FORM:
                return Yii::$container->get(ApplicationViewService::class);
        }
    }
}
