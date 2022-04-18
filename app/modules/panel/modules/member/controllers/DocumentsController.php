<?php

namespace app\modules\panel\modules\member\controllers;

use app\core\manage\Auth\UserIdentity;
use app\core\repositories\readModels\Documents\DocumentReadRepository;
use app\core\traits\GridViewTrait;
use app\models\SearchModels\Documents\MemberDocumentSearch;
use app\modules\panel\controllers\AccessRule\BaseMemberController;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

/**
 * Description of DocumentsController
 *
 * @property MemberDocumentSearch $searchModel
 * @author kotov
 */
class DocumentsController extends BaseMemberController
{
    use GridViewTrait;
    
    public function __construct(
            $id, 
            $module, 
            DocumentReadRepository $repository,
            MemberDocumentSearch $searchModel,
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
        $this->readRepository = $repository;
        $this->searchModel = $searchModel;
    } 
    
    public function actionIndex($exhibitionId) 
    {
        Url::remember();
        /** @var UserIdentity $user */
        $user = Yii::$app->user->getIdentity();
        $dataProvider = $this->getDataProvider($exhibitionId,$user->getCompany()->id);
        $pageDataProvider = $this->configurePagination($dataProvider);
        return $this->render('index',[            
            'searchModel' => $this->searchModel,
            'dataProvider' => $pageDataProvider->getDataProvider(),
            'rowsCountForm' => $pageDataProvider->getRowsCountForm(),
            'pagination' => $this->showPagination
        ]);
    }     
    
    protected function getDataProvider($exhibitionId, $companyId): ActiveDataProvider
    {
        return $this->searchModel->searchForExhibition($exhibitionId, $companyId);
    }
}
