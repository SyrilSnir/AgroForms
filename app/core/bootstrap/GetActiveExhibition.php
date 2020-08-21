<?php

namespace app\core\bootstrap;

use app\core\services\operations\Exhibition\ExhibitionService;
use Yii;
use yii\base\BootstrapInterface;
use yii\base\Model;
use yii\web\Application;

/**
 * Description of GetActiveExhibition
 *
 * @author kotov
 */
class GetActiveExhibition extends Model implements BootstrapInterface
{
    
    //put your code here
    public function bootstrap($app)
    {
        /** @var Application $app */        
        /** @var ExhibitionService $service */        
        $service = Yii::$container->get(ExhibitionService::class);
        Yii::$app->params['activeExhibition'] = $service->getActiveExhibition();
        
    }

}
