<?php

namespace app\modules\panel\modules\lists\controllers;

use app\core\repositories\readModels\Nomenclature\RubricatorReadRepository;
use app\core\services\operations\Nomenclature\RubricatorService;
use app\models\ActiveRecord\Nomenclature\Rubricator;
use app\models\Forms\Nomenclature\RubricatorForm;
use app\modules\panel\controllers\CrudController;
use DomainException;
use Yii;

/**
 * Description of RubricatorController
 *
 * @author kotov
 */
class RubricatorController extends CrudController
{
       
    public function __construct(
            $id, 
            $module, 
            RubricatorReadRepository $repository,
            RubricatorService $service,
            RubricatorForm $form,
            $config = array()
            )
    {
       parent::__construct($id, $module,$service,$repository,$form, $config);
    }

    public function actionIndex()
    {
        $isShowAll = \Yii::$app->request->get('showAll');
        return $this->render('index',[
            'showAll' => $isShowAll == 'true' ? true : false
        ]);
    }


    public function actionCreateAjax() 
    {
        /** @var Rubricator $model */
        $this->prepareCreate();            
        if ($this->form->load(Yii::$app->request->post()) && $this->form->validate()) {
            try {
                $entity = $this->service->create($this->form);
                return $this->refresh();
            } catch (DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            
        }        
        return $this->renderAjax('form-ajax', [
            'model' => $this->form,
            'isUpdate' => false
        ]);         
    }
    
    public function actionUpdateAjax() 
    {
        /** @var Rubricator $model */
        $rubricatorId = Yii::$app->request->post('id');
        if (empty($rubricatorId)) {
            throw new DomainException('Не найден раздел рубрикатора');
        }
        $model = $this->findModel($rubricatorId);
        $model->disableMultilang();
        $form = $this->form::createWithModel($model);
        $this->prepareUpdate($form);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->service->edit($rubricatorId, $form);
            return $this->refresh();
        }
        
        return $this->renderAjax('form-ajax', [
            'model' => $form,
            'isUpdate' => !$model->isNewRecord
        ]);         
    }
    
    public function actionMove(int $item, int $second, string $action)
    {
        $itemNode = $this->readRepository->findById($item);
        $secondNode = $this->readRepository->findById($second);

        $siblings = $itemNode->siblings;
        /** @var Rubricator $itemNode */
        /** @var Rubricator $secondNode */
        
        switch ($action) {
            case 'before': 
                $itemNode->insertBefore($secondNode);
                $itemOrder = $itemNode->order;
                $secondOrder = $secondNode->order;  
                $newItemOrder = ($itemOrder > $secondOrder) ? $secondNode->order : $secondNode->order - 1;
                array_walk($siblings, function(Rubricator $el) use ($itemOrder, $secondOrder) {
                    if ($itemOrder < $secondOrder) {
                        if ($el->order < $secondOrder && $el->order > $itemOrder) {
                            $el->order-= 1;
                            $el->save();
                        }
                    } elseif ($itemOrder > $secondOrder) {
                        if ($el->order < $itemOrder && $el->order >= $secondOrder) {
                            $el->order+= 1;
                            $el->save();
                        }
                    }
                });               
                $itemNode->order = $newItemOrder;
                $itemNode->save();
                break;
            case 'after':
                $itemNode->insertAfter($secondNode);
                $itemOrder = $itemNode->order;
                $secondOrder = $secondNode->order;  
                $newItemOrder = ($itemOrder > $secondOrder) ? $secondNode->order + 1 : $secondNode->order;
                array_walk($siblings, function(Rubricator $el) use ($itemOrder, $secondOrder) {
                    if ($itemOrder < $secondOrder) {
                        if ($el->order > $itemOrder && $el->order <= $secondOrder) {
                            $el->order-= 1;
                            $el->save();
                        }
                    } elseif ($itemOrder > $secondOrder) {
                        if ($el->order > $itemOrder && $el->order <= $secondOrder) {
                            $el->order+= 1;
                            $el->save();
                        }
                    }
                });                
                $itemNode->order = $newItemOrder;
                $itemNode->save();
                break;
        }
        
   //     $itemNode->
        return true;
    }
}
