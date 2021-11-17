<?php

namespace app\core\services\operations\Requests;

use app\core\manage\Configuration\ConfigurationManager;
use app\core\repositories\manage\Forms\StandRepository;
use app\core\repositories\manage\Requests\RequestRepository;
use app\core\repositories\manage\Requests\RequestStandRepository;
use app\models\ActiveRecord\Forms\FormType;
use app\models\ActiveRecord\Forms\Stand;
use app\models\ActiveRecord\Requests\Request;
use app\models\ActiveRecord\Requests\RequestStand;
use app\models\Forms\Requests\StandForm;

/**
 * Description of RequestStandsService
 *
 * @author kotov
 */
class RequestStandService
{
    /**
     *
     * @var RequestStandRepository
     */
    public $requestStands;
    
    /**
     *
     * @var RequestRepository
     */
    public $requests;
    
    /**
     *
     * @var StandRepository
     */
    public $stands;
    
    /**
     *
     * @var ConfigurationManager
     */
    private $configurationManager;

    public function __construct(
            RequestStandRepository $requestStands,
            RequestRepository $requests,
            StandRepository $standRepository,
            ConfigurationManager $configurationManager
            )
    {
        $this->requestStands = $requestStands;
        $this->requests = $requests;
        $this->stands = $standRepository;
        $this->configurationManager = $configurationManager;
    }

/**
 * 
 * @param StandForm $form
 * @param int $exhibitionId
 */
    public function create(StandForm $form,int $exhibitionId)
    {
        $request = Request::create(
                $form->userId, 
                
                $exhibitionId,
                FormType::SPECIAL_STAND_FORM,
                $form->draft
                );
        $this->requests->save($request);
        
        /** @var Stand $stand */
        $stand = $this->stands->get($form->standId);
        $amount = $this->calculatePrice(
                $form,
                $stand
                );
        $requestStand = RequestStand::create(
            $request->id,
            $form->standId,
            $form->square,
            $form->width,
            $form->length, 
            $form->frizeName, 
            $stand->price,
            $form->frizeDigitPrice,
            $amount
        );
        if ($form->loadedFile) {
            $requestStand->setFile($form->loadedFile);
        }
        $this->requestStands->save($requestStand);
    }
    
    /**
     * 
     * @param int $id
     * @param StandForm $form
     * @param int $exhibitionId
     */
    public function edit(int $id, StandForm $form) 
    {
        /** @var Stand $stand */
        /** @var RequestStand $requestStand */
        /** @var Request $request */
        $requestStand = $this->requestStands->get($id);        
        $stand = $this->stands->get($form->standId);
        $request = $this->requests->get($requestStand->request_id);
        if (!$form->draft) {
            $request->was_rejected ? 
                    $request->setStatusChanged() : 
                    $request->setStatusNew();
            $this->requests->save($request);            
        } else {
            if (!$request->isDraft()) {
                $request->setStatusDraft();
                $this->requests->save($request);                 
            }
        }
        $amount = $this->calculatePrice(
                $form,
                $stand
                );

        $requestStand->edit(
                $form->standId, 
                $form->square, 
                $form->width, 
                $form->length, 
                $form->frizeName,
                $stand->price,
                $form->frizeDigitPrice, 
                $amount);
        if ($form->loadedFile) {
            $requestStand->setFile($form->loadedFile);
        }
        $this->requestStands->save($requestStand);
    }
 
    protected function calculatePrice(StandForm $form, Stand $stand):int 
    {
        $standConfig = $this->configurationManager->getStandConfiguration();
        
        $standPrice = $form->square * $stand->price;
        $frizeName = preg_replace("/[\s]/","",$form->frizeName);
        $paidSymbolsCount = mb_strlen($frizeName) - $standConfig->frizeFreeDigits;
        $paidSymbolsCount = ($paidSymbolsCount > 0) ? $paidSymbolsCount : 0;
        
        $frizePrise = $paidSymbolsCount * $standConfig->frizeDigitPrice;
        return ($standPrice + $frizePrise);
    }
}
