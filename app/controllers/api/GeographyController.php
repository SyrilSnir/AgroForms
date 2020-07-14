<?php

namespace app\controllers\api;

use app\controllers\JsonController;
use app\core\helpers\Data\CitiesHelper;
use app\core\helpers\Data\RegionsHelper;
use Yii;

/**
 * Description of GeographyController
 *
 * @author kotov
 */
class GeographyController extends JsonController
{
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
