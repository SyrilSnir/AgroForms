<?php

namespace app\controllers\api;

use app\controllers\JsonController;
use app\core\helpers\Data\CitiesHelper;
use app\core\helpers\Data\CountriesHelper;
use app\core\helpers\Data\RegionsHelper;
use app\core\helpers\View\Form\BaseFormHelper;
use Yii;

/**
 * Description of GeographyController
 *
 * @author kotov
 */
class GeographyController extends JsonController
{
    public function actionGetCountries($label) 
    {
        $lang = $label !== BaseFormHelper::COMPANY_ADDRESS_ENG ? 'ru' : 'en';
        
        $helper = new CountriesHelper();
        $countriesData = $helper->countriesList();
        $resArray = array_map(function($element) use ($lang) {
            $result = [
                'id' => $element['id'],
                'text' => $lang == 'ru' ? 
                        $element['name'] : 
                        (!empty($element['name_eng']) ?
                            $element['name_eng'] : 
                            $element['name'])
            ];
            return $result;
        }, $countriesData);
        return $resArray;
    }
    
    public function actionGetRegions()
    {
        $countryId = (int) Yii::$app->request->post('depdrop_parents')[0];
        if ($countryId)
        {
            $regions = RegionsHelper::getRegionsOfCountry($countryId);
            $resArray = [
                'output' => $regions,
            ];
            if (count($regions) > 0) {
                $resArray['selected'] = $regions[0]['id'];
            }
            return $resArray;
        }
        return [
                    'output' => [
                        ]
            ];
    }
    
    public function actionGetCities()
    {
        $regionId = (int) Yii::$app->request->post('depdrop_parents')[0];
        if ($regionId)
        {
            $cities = CitiesHelper::getCitiesOfRegion($regionId);
            $resArray = [
                'output' => $cities,
            ];
            if (count($cities) > 0) {
                $resArray['selected'] = $cities[0]['id'];
            }
            return $resArray;
        }
        return [
                    'output' => [
                        ]
            ];
    }
}
