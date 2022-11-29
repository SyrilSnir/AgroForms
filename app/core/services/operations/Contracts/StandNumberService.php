<?php

namespace app\core\services\operations\Contracts;

use app\core\repositories\manage\Contract\StandNumberRepository;
use app\core\services\operations\DataManqageInterface;
use app\models\ActiveRecord\Contract\StandNumber;
use app\models\Forms\Manage\ManageForm;
use yii\db\ActiveRecord;

/**
 * Description of StandNumberService
 *
 * @author kotov
 */
class StandNumberService implements DataManqageInterface
{
    /**
     * 
     * @var StandNumberRepository
     */
    protected $repository;
    
    public function __construct(StandNumberRepository $repository)
    {
        $this->repository = $repository;
    }
    
    public function create(ManageForm $form): ActiveRecord
    {
        /** @var StamdNumberForm $form */
        $standNumber = StandNumber::create($form);
        $this->repository->save($standNumber);
        return $standNumber;
    }

    public function edit(int $id, ManageForm $form): void
    {
        /** @var StandNumber $standNumber */
        $standNumber = $this->repository->get($id);
        $standNumber->edit($form);
        $this->repository->save($standNumber);
    }

    public function remove(int $id): void
    {
        $standNumber = $this->repository->get($id);
        $this->repository->remove($standNumber);
    }
}
