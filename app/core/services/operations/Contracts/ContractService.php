<?php

namespace app\core\services\operations\Contracts;

use app\core\repositories\manage\Contract\ContractRepository;
use app\core\services\operations\DataManqageInterface;
use app\models\ActiveRecord\Contract\Contracts;
use app\models\Forms\Manage\ManageForm;

/**
 * Description of ContractService
 *
 * @author kotov
 */
class ContractService implements DataManqageInterface
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
    
    public function create(ManageForm $form): Contracts
    {
        $contract = Contracts::create($form);
        $this->contracts->save($contract);
        return $contract;
    }
    
    public function edit($id, ManageForm $form): void
    {
        /** @var Contracts $contract */
        $contract = $this->contracts->get($id);
        $contract->edit($form);
        $this->contracts->save($contract);                
    }
    
    public function remove ($id): void
    {        
        /* @var Contracts $contract */
         $contract = $this->contracts->get($id);
         $this->contracts->remove($contract);
    }    

}
