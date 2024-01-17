<?php

namespace app\controllers\api;

use app\controllers\JsonController;
use app\core\helpers\Data\TreeTraversalHelper;
use app\models\ActiveRecord\Exhibition\Catalog;
use app\models\ActiveRecord\Nomenclature\Rubricator;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use function mb_substr;

/**
 * Description of ExhibitorsController
 *
 * @author kotov
 */
class ExhibitorsController extends JsonController
{       
    public function actions(): array
    {
        if (in_array($_SERVER['HTTP_ORIGIN'],[
            'http://agrosalon.local',
            'https://agrosalon.ru',
            'https://www.agrosalon.ru'
        ])) {
            $this->response->headers->add('Access-Control-Allow-Origin',$_SERVER['HTTP_ORIGIN']);
        }
        return parent::actions();
    }
    public function actionIndex($exhibitionId)
    {
        $result = Catalog::find(['exhibition_id' => $exhibitionId])
                ->joinWith(['countries','rubrics'])->asArray()->all();
        $countriesList = [];
        $result = array_map(function($el) use (&$countriesList){
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
        },$result);
        $rusCapitalLetters = array_unique(ArrayHelper::getColumn($result, 'capital_letter'));
        $engCapitalLetters = array_unique(ArrayHelper::getColumn($result, 'capital_letter_eng'));
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
        
        $tree = Rubricator::findOne(1)->sortedTree(false)[0];
        TreeTraversalHelper::addAdditionalDataToTree($tree, ['checked' => false,'expanded' => false]);                
        return [
            'companies' => $result,
            'countries' => $countriesList,
            'rubricator' => $tree,
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
    }
    
    public function actionDetail($catalogId) {            
        $model = Catalog::find()->joinWith(['countries','rubrics','contacts'])->andWhere(['catalog.id' => $catalogId])->asArray()->one();
        if (!empty($model['logo_file'])) {
            $model['logo_url'] = Url::base(true). 
                        Yii::getAlias('@catalogUrl').'/'.
                         $model['id'] . '/' .
                        $model['logo_file'];
            } else {
                $model['logo_url'] = '';
            }
        return $model;        
    }
}
