<?php


namespace app\models\Forms\Manage\Document;

use app\core\traits\Lists\GetCompanyNamesTrait;
use app\core\traits\Lists\GetExhibitionsTrait;
use app\models\ActiveRecord\Document\Documents;

/**
 * Description of DocumentForm
 *
 * @author kotov
 */
class DocumentForm extends BaseDocumentForm
{
    public $title;
    public $titleEng;
    public $description;
    public $descriptionEng;
    public $companyId;
    public $exhibitionId;
    public $file;
    public $fileUrl;


    use GetCompanyNamesTrait, GetExhibitionsTrait;

    public function __construct(Documents $model = null, $config = []) 
    {
        parent::__construct($model, $config);
        if ($model) {
            $this->companyId = $model->company_id;
            $this->exhibitionId = $model->exhibition_id;
        }
    }  
}
