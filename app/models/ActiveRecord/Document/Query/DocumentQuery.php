<?php

namespace app\models\ActiveRecord\Document\Query;

use yii\db\ActiveQuery;

/**
 * Description of DocumentQuery
 *
 * @author kotov
 */
class DocumentQuery extends ActiveQuery
{
    public function forExhibition(int $exhibitionId, $alias = null): self
    {
        return $this->andWhere([($alias ? $alias . '.' : '') . 'exhibition_id' => $exhibitionId]);        
    }
    
    public function forCompany(int $companyId, $alias = null): self
    {
        return $this->andWhere([($alias ? $alias . '.' : '') . 'company_id' => $companyId]);        
    }    
}
