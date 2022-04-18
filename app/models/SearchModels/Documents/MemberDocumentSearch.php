<?php


namespace app\models\SearchModels\Documents;

/**
 * Description of MemberDocumentSearch
 *
 * @author kotov
 */
class MemberDocumentSearch extends BaseDocumentSearch
{
    public function searchForExhibition(int $exhibitionId,int $companyId, array $params = [])
    {       
        $dp = $this->baseSearch($params);
        $dp->query->forExhibition($exhibitionId); 
        $dp->query->forCompany($companyId);
        return $dp;
    }
        
}
