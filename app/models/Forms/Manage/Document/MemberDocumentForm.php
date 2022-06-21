<?php

namespace app\models\Forms\Manage\Document;

use app\models\ActiveRecord\Document\Documents;

/**
 * Description of MemberDocumentForm
 *
 * @author kotov
 */
class MemberDocumentForm extends BaseDocumentForm
{
    public function __construct(int $companyId, int $exhibitionId, Documents $model = null, $config = [])
    {
        $this->companyId = $companyId;
        $this->exhibitionId = $exhibitionId;
        parent::__construct($model, $config);
    }
}
