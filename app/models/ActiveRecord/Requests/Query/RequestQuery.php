<?php

namespace app\models\ActiveRecord\Requests\Query;

use app\models\ActiveRecord\Requests\BaseRequest;
use yii\db\ActiveQuery;

/**
 * Description of RequestQuery
 *
 * @author kotov
 */
class RequestQuery extends ActiveQuery
{
    /**
     * 
     * @param int $userId
     * @param type $alias
     * @return $this
     */
    public function forUser(int $userId, $alias = null) :self
    {
        return $this->andWhere([($alias ? $alias . '.' : '') . 'user_id' => $userId]);
    }
    
    /**
     * 
     * @param int $exhibitionId
     * @param type $alias
     * @return \self
     */
    public function forExhibition(int $exhibitionId, $alias = null) :self
    {
        return $this->andWhere([($alias ? $alias . '.' : '') . 'exhibition_id' => $exhibitionId]);
    }
    
    /**
     * 
     * @param int $contractId
     * @param type $alias
     * @return \self
     */
    public function forContract(int $contractId, $alias = null) :self
    {
        return $this->andWhere([($alias ? $alias . '.' : '') . 'contract_id' => $contractId]);
    } 
    
    public function forCompany(int $companyId, $alias = null): self
    {
        return $this->andWhere([($alias ? $alias . '.' : '') . 'company_id' => $companyId]);        
    }    
    
    public function forStands()
    {
        return $this->joinWith('stand',true,'RIGHT JOIN');
    }
    
    public function new()
    {
        return $this->andWhere(['status' => 
                                    [
                                        BaseRequest::STATUS_NEW,
                                        BaseRequest::STATUS_CHANGED
                                    ]
                                ]);
    }
    
    public function accepted()
    {
        return $this->andWhere(['status' => 
                                    [
                                        BaseRequest::STATUS_ACCEPTED,
                                        BaseRequest::STATUS_INVOICED,
                                        BaseRequest::STATUS_PAID,
                                        BaseRequest::STATUS_PARTIAL_PAID, 
                                        BaseRequest::STATUS_PUBLICATED,
                                        BaseRequest::STATUS_NOT_PUBLICATED
                                    ] 
                                ]);        
    }
    
    public function rejected()
    {
        return $this->andWhere(['status' => BaseRequest::STATUS_REJECTED ]);
    }
    
}
