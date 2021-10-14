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
     * @var FormRepository
     */
    protected $forms;
    
    public function __construct(
            FormRepository $repository
            )
    {
        $this->forms = $repository;
        
    }
    
    public function create(FormsForm $form):Form
    {
        $model = Form::create($form);
        $this->forms->save($model);
        return $model;
    }
    
    public function edit($id, FormsForm $form)
    {
        /** @var Form $model */
        $model = $this->forms->get($id);
        $model->edit($form);
        $this->forms->save($model);  
    }
    
    public function publish(int $id)
    {
        /** @var Form $model */
        $model = $this->forms->get($id); 
        $model->publish();
        $this->forms->save($model);       
    }
    
    public function unpublish(int $id)
    {
        /** @var Form $model */
        $model = $this->forms->get($id);        
        $model->toDraft();
        $this->forms->save($model);        
    }    
    
    
    
}
