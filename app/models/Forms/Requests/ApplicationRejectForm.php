<?php

namespace app\models\Forms\Requests;

use yii\base\Model;

/**
 * Description of ApplicationRejectForm
 *
 * @author kotov
 */
class ApplicationRejectForm extends Model
{
    public $comment;
    
    public $commentEng;
    
    public $requestId;


    public function __construct(int $requestId, $config = [])
    {
        $this->requestId = $requestId;
        parent::__construct($config);
    }
    
    public function rules(): array
    {
        return [
            ['requestId','required'],
            ['requestId','integer'],
            [['comment','commentEng'],'safe']
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'comment' => t('Comment'),
            'commentEng' => t('Comment') . ' (ENG)',
        ];
    }
}
