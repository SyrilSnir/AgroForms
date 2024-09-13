<?php

namespace app\controllers\api;

use app\controllers\JsonController;
use app\core\services\Catalog\PublicateService;
use app\models\ActiveRecord\Exhibition\Catalog;
use Yii;
use yii\helpers\Url;


/**
 * Description of ExhibitorsController
 *
 * @author kotov
 */
class ExhibitorsController extends JsonController
{   
    /**
     * 
     * @var PublicateService
     */
    protected $publicateService;
    
    public function __construct($id, $module,PublicateService $publicateService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->publicateService = $publicateService;
    }
    
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
    
    public function actionAgrocomponents(int $exhibitionId) 
    {
        return $this->publicateService->publicateAgrocomponents($exhibitionId);
    }
    public function actionIndex(int $exhibitionId)
    {
        return $this->publicateService->publicateCatalog($exhibitionId);
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
