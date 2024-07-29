<?php

namespace app\core\services\operations\Exhibition;

use app\core\repositories\manage\Exhibition\ExhibitionRepository;
use app\core\services\operations\DataManqageInterface;
use app\models\ActiveRecord\Exhibition\Exhibition;
use app\models\Forms\Manage\ManageForm;
use yii\caching\Cache;
use yii\db\ActiveRecord;

/**
 * Description of ExhibitionService
 *
 * @author kotov
 */
class ExhibitionService implements DataManqageInterface
{
    /**
     *
     * @var ExhibitionRepository
     */
    protected $exhibitions;
    
    /**
     *
     * @var Cache
     */
    protected $cacheSystem;
   
    public function __construct(ExhibitionRepository $exhibitions, Cache $cacheSystem)
    {
        $this->exhibitions = $exhibitions;
        $this->cacheSystem = $cacheSystem;
    }


    public function create(ManageForm $form) : ActiveRecord
    {
        $exhibition = Exhibition::create($form);
        $this->exhibitions->save($exhibition);
        return $exhibition;
    }
    
    public function edit($id , ManageForm $form) :void
    {
        /** @var Exhibition $exhibition */
        $exhibition = $this->exhibitions->get($id);
        $exhibition->edit($form);
        $this->exhibitions->save($exhibition);
    } 
    
    public function getActiveExhibition()
    {
        if ($this->cacheSystem) {
            $result = $this->cacheSystem->get('activeExhibition');
            if ($result) {
                return $result;
            }
        }
        $currentTime = time();
        $activeExhibition = Exhibition::find()->where(['>=','end_date', $currentTime])->one();
        if (!$activeExhibition) {
            return;
        }
        $this->cacheSystem->set('activeExhibition',$activeExhibition->id);
        return $activeExhibition->id;
    }

    public function remove(int $id): void
    {
        
    }
}
