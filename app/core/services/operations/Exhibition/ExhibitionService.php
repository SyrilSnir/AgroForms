<?php

namespace app\core\services\operations\Exhibition;

use app\core\repositories\manage\Exhibition\ExhibitionRepository;
use app\models\ActiveRecord\Exhibition\Exhibition;
use app\models\Forms\Manage\Exhibition\ExhibitionForm;
use yii\caching\Cache;

/**
 * Description of ExhibitionService
 *
 * @author kotov
 */
class ExhibitionService
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


    public function create(ExhibitionForm $form) 
    {
        $exhibition = Exhibition::create($form);
        $this->exhibitions->save($exhibition);
        return $exhibition;
    }
    
    public function edit($id , ExhibitionForm $form) 
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

}
