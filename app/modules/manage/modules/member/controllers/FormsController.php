<?php

namespace app\modules\manage\modules\member\controllers;

use app\core\repositories\manage\Forms\FormRepository;
use app\core\repositories\manage\Forms\FormTypeRepository;
use app\core\repositories\manage\Requests\RequestRepository;
use app\models\ActiveRecord\Requests\Request;
use app\modules\manage\controllers\AccessRule\BaseMemberController;
use DomainException;
use Yii;

/**
 * Description of FormsController
 *
 * @author kotov
 */
class FormsController extends BaseMemberController
{
    /**
     *
     * @var FormTypeRepository
     */
    protected $formTypeRepository;
    
    /**
     *
     * @var FormRepository
     */
    protected $formsRepository;
    /**
     *
     * @var RequestRepository
     */
    protected $requestRepository;
    
    public function __construct(
            $id,
            $module, 
            FormTypeRepository $formTypeRepository,
            FormRepository $formRepository,
            RequestRepository $requestRepository,
            $config = array()
            )
    {
        $this->formTypeRepository = $formTypeRepository;
        $this->requestRepository = $requestRepository;
        $this->formsRepository = $formRepository;
        parent::__construct($id, $module, $config);
    }

    public function actionLoad(int $id,int $requestId = null)
    {
        /** @var Request $request */
        if ($requestId) {
            $request = $this->requestRepository->get($requestId);
            if($request->status !== Request::STATUS_DRAFT) {
                throw new DomainException('Данная заявка недоступна для редактирования');
            }
            Yii::$app->session->set('FORM_CHANGE_TYPE', Request::FORM_UPDATE);
            Yii::$app->session->set('REQUEST_ID', $request->id);            
        } else {
            Yii::$app->session->set('FORM_CHANGE_TYPE', Request::FORM_CREATE);
            Yii::$app->session->remove('REQUEST_ID');  
        }
        $user = Yii::$app->user->getIdentity();
        $form = $this->formsRepository->get($id);
        return $this->render('load', [
            'form' => $form,
            //'formId' => 
            'user' => $user,
        ]);
    }
}
