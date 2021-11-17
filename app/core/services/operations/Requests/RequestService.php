<?php

namespace app\core\services\operations\Requests;

use app\core\repositories\manage\Requests\RequestRepository;
use app\models\ActiveRecord\Logs\ApplicationRejectLog;
use app\models\ActiveRecord\Requests\Request;
use app\models\Forms\Requests\ApplicationRejectForm;
use app\models\Forms\Requests\ChangeStatusForm;

/**
 * Description of RequestService
 *
 * @author kotov
 */
class RequestService
{
    /**
     *
     * @var RequestRepository
     */
    protected $requests;
    
    public function __construct(RequestRepository $requests)
    {
        $this->requests = $requests;
    }
    
    public function changeStatus(ChangeStatusForm $form)
    {
        /** @var Request $request */
        $request = $this->requests->get($form->requestId);
        $request->status = $form->status;
        $this->requests->save($request);
        return $request;
    }

    public function remove ($id) 
    { 
        /** @var Request $request */
        $request = $this->requests->get($id);
        $form = $request->requestForm;
        if ($form) {
            $form->delete();
        }
        $this->requests->remove($request);
    }
    
    /**
     * Принять заявку
     * @param int $id Идентификатор заявки
     */
    public function accept(int $id)
    {
        /** @var Request $request */        
        $request = $this->requests->get($id);
        $request->accept();
        $request->save();        
    }
    
    /**
     * Отклонить заявку
     * @param int $id Идентификатор заявки
     */
    public function reject(ApplicationRejectForm $form)
    {
        /** @var Request $request */
        $request = $this->requests->get($form->requestId);
        $logField = ApplicationRejectLog::create(
                $form->requestId, 
                $form->comment,
                $form->commentEng);
        $request->reject();
        $logField->save();
        $request->save();
    }   
    
    /**
     * Выставить счет
     * @param int $id Идентификатор заявки
     */
    public function invoice(int $id)
    {
        /** @var Request $request */
        $request = $this->requests->get($id);
        $request->invoice();
        $request->save();
    }      
}
