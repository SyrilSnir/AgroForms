<?php

namespace app\models\Forms\Manage\Document;

use app\models\ActiveRecord\Document\Documents;
use yii\helpers\ArrayHelper;

/**
 * Description of MemberDocumentForm
 *
 * @author kotov
 */
class MemberDocumentForm extends BaseDocumentForm
{
    public $companyId;
    public $exhibitionId;
    
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        $rules = [
            [['companyId','exhibitionId'], 'required'],
            [['companyId','exhibitionId'], 'integer'],
        ];
        return ArrayHelper::merge($rules, parent::rules());
    }   
    public function __construct(int $companyId, int $exhibitionId, Documents $model = null, $config = [])
    {
        $this->companyId = $companyId;
        $this->exhibitionId = $exhibitionId;
        parent::__construct($model, $config);
    }
}
