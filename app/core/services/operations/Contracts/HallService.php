<?php

namespace app\core\services\operations\Contracts;

use app\core\repositories\manage\Contract\HallRepository;
use app\core\services\operations\DataManqageInterface;
use app\models\ActiveRecord\Contract\Hall;
use app\models\Forms\Manage\ManageForm;
use yii\db\ActiveRecord;

/**
 * Description of HallService
 *
 * @author kotov
 */
class HallService implements DataManqageInterface
{
    /**
     * 
     * @var HallRepository
     */
    protected $repository;
    
    public function __construct(HallRepository $repository)
    {
        $this->repository = $repository;
    }
    
    public function create(ManageForm $form): ActiveRecord
    {
        /** @var StamdNumberForm $form */
        $hall = Hall::create($form);
        $this->repository->save($hall);
        return $hall;
    }

    public function edit(int $id, ManageForm $form): void
    {
        /** @var Hall $hall */
        $hall = $this->repository->get($id);
        $hall->edit($form);
        $this->repository->save($hall);
    }

    public function remove(int $id): void
    {
        $hall = $this->repository->get($id);
        $this->repository->remove($hall);
    }
}
