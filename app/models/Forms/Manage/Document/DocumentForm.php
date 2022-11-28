<?php


namespace app\models\Forms\Manage\Document;

use app\core\traits\Lists\GetCompanyNamesTrait;
use app\core\traits\Lists\GetExhibitionsTrait;
use app\models\ActiveRecord\Document\Documents;
use yii\helpers\ArrayHelper;

/**
 * Description of DocumentForm
 *
 * @author kotov
 */
class DocumentForm extends BaseDocumentForm
{
    public $companyId;
    public $exhibitionId;    
    
    use GetCompanyNamesTrait, GetExhibitionsTrait;

    public function __construct(Documents $model = null, $config = []) 
    {
        parent::__construct($model, $config);
        if ($model) {
            $this->companyId = $model->company_id;
            $this->exhibitionId = $model->exhibition_id;
        }
    } 
    
    public function rules() :array 
    {
        return ArrayHelper::merge([
            [['exhibitionId'], 'required'],
            [['companyId','exhibitionId'], 'integer'],
        ], parent::rules());
    }
    
    public function attributeLabels() :array
    {
        return ArrayHelper::merge([
            'companyId' => t('Company','company'),
            'exhibitionId' => t('Exhibition'), 
        ], parent::attributeLabels());
    }
}
