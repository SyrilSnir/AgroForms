<?php

namespace app\core\services\Catalog;

use app\core\helpers\Data\TreeTraversalHelper;
use app\models\ActiveRecord\Exhibition\Catalog;
use app\models\ActiveRecord\Nomenclature\Rubricator;
use Yii;
use yii\db\ActiveQuery;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use function mb_convert_case;
use function mb_substr;

/**
 * Description of PublicateService
 *
 * @author kotov
 */
class PublicateService
{
    
    public function publicateCatalog(int $exhibitionId) :array 
    {    
        $catalogQuery = $this->getQueryForCatalogData($exhibitionId);
        $this->joinRubrics($catalogQuery);
        $catalogData = $catalogQuery->orderBy(['company' => SORT_ASC, 'company_eng' => SORT_ASC])->asArray()->all();
        $result= $this->appendCountriesAndCapitalLetters($catalogData);
        return $result;
    }
    public function publicateAgrocomponents(int $exhibitionId) :array 
    {
        $catalogQuery = $this->getQueryForCatalogData($exhibitionId);
        $this->joinRubricsForAgrocomponent($catalogQuery);
        $catalogData = $catalogQuery->orderBy(['company' => SORT_ASC, 'company_eng' => SORT_ASC])->asArray()->all();
        $result = $this->appendCountriesAndCapitalLetters($catalogData);
        return $result;
    }
    
    private function getQueryForCatalogData(int $exhibitionId): ActiveQuery 
    {
        return  Catalog::find(['exhibition_id' => $exhibitionId])
                ->orderBy(['company' => SORT_ASC, 'company_eng' => SORT_ASC])
                ->joinWith(['countries']);      
    }
    
    private function joinRubrics(ActiveQuery $catalogQuery) :void
    {
        $catalogQuery->joinWith('rubrics');
    }
    
    private function joinRubricsForAgrocomponent(ActiveQuery $catalogQuery): void 
    {
        $rubricsList = $this->getAgrocomponentRubrics();
        $catalogQuery->joinWith(['rubrics' => function(Query $query) use ($rubricsList) {
            $query->andWhere(['rubricator.id' => $rubricsList]);
        }]);
    }
    
    private function getAgrocomponentRubrics() 
    {      
        $rootLevel = Rubricator::findOne(251);
        $agrocomponentIds = ArrayHelper::getColumn($rootLevel->children()->asArray()->all(), 'id');
        return $agrocomponentIds;
    }
    
    private function appendCountriesAndCapitalLetters(array $catalogData) : array
    {
        $countriesList = [];
        $catalogData = array_map(function($el) use (&$countriesList){
            $el['show_description'] = false;
            if (!empty($el['logo_file'])) {
                $el['logo_url'] = Url::base(true). 
                        Yii::getAlias('@catalogUrl').'/'.
                         $el['id'] . '/' .
                        $el['logo_file'];
            } else {
                $el['logo_url'] = '';
            }
            
            $el['capital_letter'] = mb_convert_case(mb_substr($el['company'],0,1), MB_CASE_LOWER);
            $el['capital_letter_eng'] = mb_convert_case(mb_substr($el['company_eng'],0,1), MB_CASE_LOWER);
            if (!empty($el['countries'])) {
                foreach ($el['countries'] as $country) {
                    if(!key_exists($country['id'], $countriesList)) {
                        $countriesList[$country['id']] = [
                            'name' => $country['name'],
                            'nameEng' => $country['name_eng'],
                        ];
                    }
                }
            }
            return $el;
        },$catalogData); 
        $rusCapitalLetters = array_unique(ArrayHelper::getColumn($catalogData, 'capital_letter'));
        $engCapitalLetters = array_unique(ArrayHelper::getColumn($catalogData, 'capital_letter_eng'));
        $russianAlphabet = ['а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','э','ю','я'];
        $latinAlphabet = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','0','1','2','3','4','5','6','7','8','9'];
        
        $rusLetters = [];
        $latLetters = [];
        $rusLettersEng = [];
        $latLettersEng = [];
        foreach ($russianAlphabet as $rusAlpha) {
            $rusLetters[] = [
                'character' => $rusAlpha,
                'isHide' => !in_array($rusAlpha, $rusCapitalLetters)
            ];
            $rusLettersEng[] = [
                'character' => $rusAlpha,
                'isHide' => !in_array($rusAlpha, $engCapitalLetters)
            ];            
        }
        foreach ($latinAlphabet as $latAlpha) {
            $latLetters[] = [
                'character' => $latAlpha,
                'isHide' => !in_array($latAlpha, $rusCapitalLetters)
            ];
            $latLettersEng[] = [
                'character' => $latAlpha,
                'isHide' => !in_array($latAlpha, $engCapitalLetters)
            ];            
        }        
        $result = [
            'companies' => $catalogData,
            'countries' => $countriesList,
            'alphabet' => [
                'rus' => [
                    'russian' => $rusLetters,
                    'english' => $rusLettersEng,
                ],
                'lat' => [
                    'russian' => $latLetters,
                    'english' => $latLettersEng,
                ]
            ]            
            
        ];
        $tree = Rubricator::findOne(1)->sortedTree(false)[0];
        TreeTraversalHelper::addAdditionalDataToTree($tree, ['checked' => false,'expanded' => false]);
        $result['rubricator'] = $tree;                
        return $result;
    }
}
