<?php

namespace app\models\Forms\Requests;

use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Description of StandForm
 *
 * @author kotov
 */
class StandForm extends Model
{
    public $userId;
    public $standId;
    public $width;
    public $length;
    public $square;
    public $draft;
    public $frizeName;
    public $frizeDigitPrice;
    public $loadedFile;


    public function rules() 
    {   
        return [
            [['userId'],'required'],
            [['frizeName'],'safe'],
            [['loadedFile'],'file'],
            [['draft'],'boolean'],
            [['standId','userId','width','length','square','frizeDigitPrice'],'number'],
        ];
    }
    
    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->loadedFile = UploadedFile::getInstance($this, 'loadedFile');
            return true;
        }
        return false;
    }
}
