<?php

namespace app\core\services\operations\Contracts;

use app\core\repositories\manage\Contract\ContractRepository;
use app\models\ActiveRecord\Contract\Contracts;
use app\models\Forms\Manage\Contract\ContractForm;

/**
 * Description of ContractService
 *
 * @author kotov
 */
class ContractService 
{
    /**
     * 
     * @var ContractRepository
     */
    protected $contracts;
    
    public function __construct(ContractRepository $contracts) 
    {
        $this->contracts = $contracts;
    }
    
    public function create(ContractForm $form)
    {
        $contract = Contracts::create($form);
        $this->contracts->save($contract);
        return $contract;
    }
    
    public function edit($id, ContractForm $form)
    {
        /** @var Contracts $contract */
        $contract = $this->contracts->get($id);
        $contract->edit($form);
        $this->contracts->save($contract);                
    }

}
