<?php

namespace app\core\repositories\manage\Exhibition;

use app\core\repositories\exceptions\NotFoundException;
use app\core\repositories\manage\DataManipulationTrait;
use app\core\repositories\manage\RepositoryInterface;
use app\models\ActiveRecord\Exhibition\Catalog;
use app\models\ActiveRecord\Exhibition\CatalogCountries;
use app\models\ActiveRecord\Exhibition\CatalogRubrics;
use RuntimeException;
use yii\db\ActiveRecord;

/**
 * Description of CatalogRepository
 *
 * @author kotov
 */
class CatalogRepository implements RepositoryInterface
{
    use DataManipulationTrait;
       
    public function get(int $id): ActiveRecord
    {
        if (!$model = Catalog::findOne($id)) {
            throw new NotFoundException('Элемент не найден');
        }
        return $model;
    }
    
    /**
     * 
     * @param int $exhibitionId
     * @return Catalog[]
     */
    public function getByExhibition(int $exhibitionId) : array
    {
        return Catalog::find()->andWhere(['exhibition_id' => $exhibitionId])->all();        
    }
    
    public function removeCountries(int $catalogId)
    {
        CatalogCountries::deleteAll(['catalog_id' => $catalogId]);
    }
    
    public function removeRubrics(int $catalogId)
    {
        CatalogRubrics::deleteAll(['catalog_id' => $catalogId]);
    }

    public function remove(ActiveRecord $model)
    {
        /** @var Catalog $model */
        $this->removeCountries($model->id);
        $this->removeRubrics($model->id);
        if (!$model->delete()) {
            throw new RuntimeException('Ошибка удаления');
        }
    }   
}
