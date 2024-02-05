<?php

namespace app\core\services\operations\Contracts;

use app\core\repositories\manage\Contract\ContractMediaFeeRepository;
use app\core\services\operations\DataManqageInterface;
use app\models\ActiveRecord\Contract\ContractMediaFees;
use app\models\Forms\Manage\Contract\ContractMediaFeeForm;
use app\models\Forms\Manage\ManageForm;
use yii\db\ActiveRecord;

/**
 * Description of ContractMediaFeeService
 *
 * @author kotov
 */
class ContractMediaFeeService  implements DataManqageInterface
{
    /**
     * 
     * @var ContractMediaFeeRepository
     */
    protected $repository;
    
    public function __construct(ContractMediaFeeRepository $repository)
    {
        $this->repository = $repository;
    }
    
    public function create(ManageForm $form): ActiveRecord
    {
        /** @var ContractMediaFeeForm $form */
        $mediaFee = ContractMediaFees::create($form);
        $this->repository->save($mediaFee);
        return $mediaFee;
    }

    public function edit(int $id, ManageForm $form): void
    {
        /** @var ContractMediaFees $mediaFee */
        $mediaFee = $this->repository->get($id);
        $mediaFee->edit($form);
        $this->repository->save($mediaFee);
    }

    public function remove(int $id): void
    {
        $mediaFee = $this->repository->get($id);
        $this->repository->remove($mediaFee);
    }
}
