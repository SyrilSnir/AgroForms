<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace app\models\Forms;

use yii\base\Model;

/**
 * Description of ShowDeletedForm
 *
 * @author kotov
 */
class ShowDeletedForm extends Model
{
    /**
     * Показ удаленных записей
     * @var bool
     */
    public $showDeleted = false;
    
    public function rules(): array
    {
        return [
            [['showDeleted'], 'boolean']
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'showDeleted' => t('Show deleted entries')
        ];
    }
}
