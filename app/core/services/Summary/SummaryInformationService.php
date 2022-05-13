<?php

namespace app\core\services\Summary;

use app\models\ActiveRecord\Companies\Company;
use app\models\ActiveRecord\Exhibition\Exhibition;

/**
 * Description of SummaryInformationService
 *
 * @author kotov
 */
class SummaryInformationService
{
    /**
     * 
     * @var Company
     */
    private $company;
    
    public function __construct(Company $company)
    {
        $this->company = $company;
    }
    
    public function getSummaryInformation() :array
    {
        /** @var Exhibition $exhibition */
        $exhibitionList = $this->company->getAvailableExhibitions();
        $result = [
            'past' => [],
            'active' => [],
            'future' => [],
        ];
        foreach ($exhibitionList as $exhibition) {
           if($exhibition->isPast()) {
               array_push($result['past'], $exhibition);
           }
           if($exhibition->isActive()) {
               array_push($result['active'], $exhibition);
           }
           if($exhibition->isFuture()) {
               array_push($result['future'], $exhibition);
           }           
        }
        return $result;
    }
}
