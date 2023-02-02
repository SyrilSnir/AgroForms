<?php

namespace app\modules\panel\modules\lists\controllers;

use app\core\repositories\readModels\Nomenclature\RubricatorReadRepository;
use app\core\services\operations\Nomenclature\RubricatorService;
use app\core\traits\GridViewTrait;
use app\models\Forms\Nomenclature\RubricatorForm;
use app\models\SearchModels\Nomenclature\RubricatorSearch;
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
    use GridViewTrait;    
    
    public function __construct(
            $id, 
            $module, 
            RubricatorReadRepository $repository,
            RubricatorService $service,
            RubricatorSearch $searchModel,
            RubricatorForm $form,
            $config = array()
            )
    {
       parent::__construct($id, $module,$service,$repository,$form, $config);
        $this->searchModel = $searchModel;
    }
    
    public function actionUpdateAjax() 
    {
        $rubricatorId = Yii::$app->request->post('id');
        if (empty($rubricatorId)) {
            throw new DomainException('Не найден раздел рубрикатора');
        }
        $model = $this->findModel($rubricatorId);
        $form = $this->form::createWithModel($model);
        $this->prepareUpdate($form);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->service->edit($id, $form);
            return $this->refresh();
        }
        return $this->renderAjax('form-ajax', [
            'model' => $form,
            'isUpdate' => !$model->isNewRecord
        ]);         
    }
}
