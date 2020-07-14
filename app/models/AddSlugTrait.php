<?php

namespace app\models;

use app\core\tools\Strings;

/**
 *
 * @author kotov
 */
trait AddSlugTrait
{
    public function beforeSave($insert) {
        if (empty($this->slug)) {
            $name = isset($this->name) ? $this->name : $this->title;
            $this->slug = strtolower(Strings::getTransliterateString($name));
        }
        return parent::beforeSave($insert);
    }
}
