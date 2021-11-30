<?php

namespace app\modules\panel\modules\member\controllers;

use app\core\services\operations\FeedbackService;
use app\models\Forms\FeedbackForm;
use app\modules\panel\controllers\AccessRule\BaseMemberController;
use Yii;


/**
 * Description of FeedbackController
 *
 * @author kotov
 */
class FeedbackController extends BaseMemberController
{
    /**
     * 
     * @var FeedbackService
     */
    protected $service;
    
    public function __construct($id, $module, FeedbackService $service,$config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }
    
    public function actionIndex() 
    {
        $form = new FeedbackForm(); 
        $userId = Yii::$app->user->getIdentity()->id;
        $form->userId = $userId;
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->service->create($form);
            return $this->render('congrat', [
                'model' => $form,
            ]);            
        }
        return $this->render('index', [
            'model' => $form,
        ]);        
    }
}
