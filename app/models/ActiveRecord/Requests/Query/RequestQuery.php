<?php

namespace app\models\ActiveRecord\Requests\Query;

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
    
    public function forStands()
    {
        return $this->joinWith('stand',true,'RIGHT JOIN');
    }
}
