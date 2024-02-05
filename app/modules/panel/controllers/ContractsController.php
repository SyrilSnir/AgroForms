<?php

namespace app\modules\panel\controllers;

use app\core\repositories\readModels\Contracts\ContractReadRepository;
use app\core\services\operations\Contracts\ContractService;
use app\core\traits\GridViewTrait;
use app\models\Forms\Manage\Contract\ContractForm;
use app\models\SearchModels\Contracts\ContractMediaFeeSearch;
use app\models\SearchModels\Contracts\ContractSearch;
use Yii;
use yii\base\Model;
use yii\helpers\Url;

/**
 * Description of ContractsController
 *
 * @author kotov
 */
class ContractsController extends CrudController
{
    use GridViewTrait;
    
    /**
     *
     * @var ContractService
     */
    protected $service;

    public function __construct(
            $id, 
            $module, 
            ContractReadRepository $repository,
            ContractService $service,
            ContractSearch $searchModel,
            ContractForm $form,
            $config = array()
            )
    {
       parent::__construct($id, $module,$service,$repository,$form, $config);
        $this->searchModel = $searchModel;
    } 

    protected function prepareUpdate(Model $form, $id = null)
    {
        parent::prepareUpdate($form, $id);
        Url::remember();
        $mediaFees = new ContractMediaFeeSearch($id);       
        $this->tplVars[ 'mediaFeeDataProvider'] = $mediaFees->search();
        $this->tplVars[ 'contractId'] = $id;
        $this->tplVars[ 'isUpdate'] = true;
    }   
    
    protected function prepareCreate() {
        parent::prepareCreate();
         $this->tplVars[ 'isUpdate'] = false;       
    }
}
