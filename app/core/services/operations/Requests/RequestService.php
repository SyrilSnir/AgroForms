<?php

namespace app\core\services\operations\Requests;

use app\core\repositories\manage\Requests\RequestRepository;
use app\core\services\Mail\MailService;
use app\core\services\operations\Logs\ApplicationRejectLogService;
use app\models\ActiveRecord\Logs\ApplicationRejectLog;
use app\models\ActiveRecord\Requests\Request;
use app\models\Forms\Requests\ApplicationRejectForm;
use app\models\Forms\Requests\EditRequestForm;
use app\models\ActiveRecord\Companies\Company;


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
    
    /**
     * 
     * @var MailService
     */
    protected $mailService;
    
    /**
     * 
     * @var ApplicationRejectLogService
     */
    protected $applicationRejectLogService;


    public function __construct(
            RequestRepository $requests,
            ApplicationRejectLogService $applicationRejectLogService,
            MailService $mailService
            )
    {
        $this->requests = $requests;
        $this->applicationRejectLogService = $applicationRejectLogService;
        $this->mailService = $mailService;
    }
    
    public function edit(EditRequestForm $form)
    {
        /** @var Request $request */
        $request = $this->requests->get($form->requestId);
        $request->edit($form);
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
        $this->applicationRejectLogService->clearActualStatusForRequest($id);
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
        $this->applicationRejectLogService->clearActualStatusForRequest($form->requestId);
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
        $this->sendInvoiceNotification($request);
    }      

    /**
     * Оплата заявки
     * @param int $id Идентификатор заявки
     */
    public function pay(int $id)
    {
        /** @var Request $request */
        $request = $this->requests->get($id);
        $request->paid();
        $request->save();
    } 

    /**
     * Частичная оплата
     * @param int $id Идентификатор заявки
     */
    public function partialPay(int $id)
    {
        /** @var Request $request */
        $request = $this->requests->get($id);
        $request->parialPaid();
        $request->save();
    } 

    public function changeStatus(EditRequestForm $form)
    {
        /** @var Request $request */
        $request = $this->requests->get($form->requestId);
        $request->status = $form->status;
        $this->requests->save($request);
        return $request;
    }
    
    private function sendInvoiceNotification(Request $request)
    {
        $member = $request->company->member;
        if (!$member) {
            return;
        }
        $this->mailService->compose([
            'html' => 'invoice-html',
            'text' => 'invoice-text',
        ], [
            'request' => $request,            
        ])->setTo($member->email)->setSubject($request->exhibition->title . ' - в вашем личном кабинете новый счет на оплату услуг')
                ->send();
    }
    
    
}
