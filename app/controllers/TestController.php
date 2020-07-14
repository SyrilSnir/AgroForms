<?php

namespace app\controllers;

use app\assets\MainAsset;
use app\core\helpers\Data\Form\FieldGroupsHelper;
use app\core\helpers\Data\Form\FieldsHelper;
use app\core\services\Mail\MailService;
use app\models\ActiveRecord\Service\Category;
use app\models\ActiveRecord\Users\Performer;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use function dump;
/**
 * Description of TestController
 *
 * @author kotov
 */
class TestController extends Controller
{
    public function init()
    {
        parent::init();
        $this->enableCsrfValidation = false;
    }

    public function actionIndex()
    {
        $this->view->registerJsFile(Yii::getAlias('@web').'/build/scripts/test.js',[
            'depends' => MainAsset::class
        ]);
        $this->setViewPath('@views/test');
        $tplVars = $this->getTemplateVariables();
        $tplVars['action'] = $tplVars['controller'];
        $tplVars['title'] = 'Тестовый контроллер';
        return $this->render('index', $tplVars);
    }  
    
    public function actionTest()
    {
        /** @var Category $service */
        /** @var Performer $p */
       // $service = \app\core\repositories\readModels\Service\CategoryReadRepository::findById(1);
      // $rep = new \app\core\repositories\manage\User\Profile\PerformerRepository();
    //   $p = $rep->get(2);
       
      //  dump ($p->languages); die();
       // $form = new \app\models\Forms\Manage\StandConfigurationForm();
       // $s = ConfigurationHelper::getConfig(Configuration::STAND_SETTINGS_SECTION);
       // $rep = new RequestStandRepository();
    //   $groups = FieldGroupsHelper::getGroupsWithFields(2);
       $fields = FieldsHelper::getUncategorizedFields(2);
     //   $stand = $rep->get(3);
     //  
     /** @var \app\models\ActiveRecord\Requests\Request $request */
     $request = \app\core\repositories\readModels\Requests\RequestReadRepository::findById(20);
     $form = $request->requestForm;
       // dump($stand->getUploadedFileUrl('file'));
      // $result = ArrayHelper::merge($groups, $fields);
     //  ArrayHelper::multisort($result,['order'],[SORT_ASC]);
       dump($request);
       dump($form);
        die;
    }

    public function actionSend()
    {
      $service = \app\core\repositories\readModels\Service\CategoryReadRepository::findById(1);
      $form = new \app\models\Forms\Service\DynamicServiceForm($service);
      
     $attributes = $form->attributes();   
     // $sendData = json_decode(Yii::$app->request->getRawBody());     
     dump($attributes); die;
    }
    
    public function actionArray()
    {
        $arr = [
            0=> 'Вася',
            1=> 'Петя',
            2=> 'Коля',
            3=> 'Нина',
            4=> 'Макар',
        ];
       // \yii\helpers\ArrayHelper::remove($arr, 3);
       array_splice($arr, 3,1);
          dump($arr);die;      
    }
    
    public function actionCountries() 
    {
        $fixture = Yii::getAlias('@fixtures') .'\city.csv';
        $lines = file($fixture);
        $arr = [];
        foreach ($lines as $line)
        {
            $arr[] = str_getcsv($line,';');
        }
        return dump ($arr);
    }
    
    public function actionMail() {
     /** @var MailService $mailService */
        $mailService = Yii::$container->get(MailService::class);
  /*      $mailService->compose([
            'html' => 'invite-html',
            'text' => 'invite-text',
        ])->setTo('truck01@mail.ru')->setSubject('Добро пожаловать')->send();*/
        dump($mailService);die();
    }
}
