<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\ActiveRecord\Users\Profile;

/**
 *
 * @author kotov
 */
interface UserProfileInterface
{
    /**
    * Возвращает информацию об оргмнизации или роде деятельности
     * @return string
     */
    public function info():string;
}
