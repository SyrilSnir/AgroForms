<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\core\services\operations\View\Requests;

use app\models\ActiveRecord\Requests\BaseRequest;

/**
 *
 * @author kotov
 */
interface RequestViewInterface
{
    /**
     * 
     * @param BaseRequest $request
     * @return array
     */
    public function getFieldAttributes(BaseRequest $request): array;        
}
