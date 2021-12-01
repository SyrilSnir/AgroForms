<?php

namespace app\core\services\operations;

use app\core\repositories\manage\FeedbackRepository;
use app\models\ActiveRecord\FeedbackFormModel;
use app\models\Forms\FeedbackForm;

/**
 * Description of FeedbackService
 *
 * @author kotov
 */
class FeedbackService
{
    /**
     * 
     * @var FeedbackRepository
     */
    protected $feedbackRepository;
    
    public function __construct(FeedbackRepository $feedbackRepository)
    {
        $this->feedbackRepository = $feedbackRepository;
    }

    
    public function create(FeedbackForm $form) : FeedbackFormModel
    {
        $model = FeedbackFormModel::create($form->userId, $form->message);
        $this->feedbackRepository->save($model);
        return $model;
    }

    public function remove ($id) 
    {               
        $model = $this->feedbackRepository->get($id);
        $this->feedbackRepository->remove($model);
    }     
}
