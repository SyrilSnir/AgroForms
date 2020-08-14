<?php

namespace app\core\services\operations\Forms;

use app\core\repositories\manage\Forms\FormRepository;
use app\models\ActiveRecord\Forms\Form;
use app\models\Forms\Manage\Forms\FormsForm;
use Yii;

/**
 * Description of FormService
 *
 * @author kotov
 */
class FormService
{
    /**
     *
     * @var FormExhibitionService 
     */
    protected $formExhibitionService;
    /**
     *
     * @var FormRepository
     */
    protected $forms;
    
    public function __construct(
            FormRepository $repository,
            FormExhibitionService $formExhibitionService
            )
    {
        $this->forms = $repository;
        $this->formExhibitionService = $formExhibitionService;
        
    }
    
    public function create(FormsForm $form):Form
    {
        $model = Form::create(
                $form->title, 
                $form->name, 
                $form->description, 
                $form->slug, 
                $form->titleEng,
                $form->nameEng,
                $form->descriptionEng,
                $form->formType, 
                $form->order, 
                $form->basePrice,
                $form->hasFile,
                $form->valute,
                Yii::$app->user->getId()
                );
        $this->forms->save($model);
        $this->postProcess($model, $form);
        return $model;
    }
    
    public function edit($id, FormsForm $form)
    {
        /** @var Form $model */
        $model = $this->forms->get($id);
        $model->edit(
                $form->title, 
                $form->name, 
                $form->description, 
                $form->slug, 
                $form->titleEng,
                $form->nameEng,
                $form->descriptionEng,                
                $form->formType, 
                $form->order,           
                $form->basePrice,
                $form->hasFile,
                $form->valute
                );
        $this->forms->save($model);  
        $this->postProcess($model, $form);
    }
    
    private function postProcess(Form $model,FormsForm $form)
    {
        if (is_array($form->exhibitionsList)) {
            $this->formExhibitionService->setExhibitions($model->id, $form->exhibitionsList);
        }
    }
    
    
}
