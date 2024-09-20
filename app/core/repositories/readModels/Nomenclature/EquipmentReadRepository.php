<?php

namespace app\core\repositories\readModels\Nomenclature;

use app\core\repositories\readModels\ReadRepositoryInterface;
use app\models\ActiveRecord\Nomenclature\Equipment;
use yii\db\Query;

/**
 * Description of EquipmentReadRepository
 *
 * @author kotov
 */
class EquipmentReadRepository implements ReadRepositoryInterface
{
    public static function findById($id)
    {
        return Equipment::find($id)
            ->andWhere(['id' => $id])
            ->one();
    }
    /**
     * 
     * @param int $exgibitionId
     * @param int|null $groupId
     * @return Equipment[]
     */
    public static function findForExhibition(int $exgibitionId, int|null $groupId = null): array
    {
        $query = self::getQueryForExhibition($exgibitionId,$groupId);        
        return $query->all();        
    }
    public static function countForExhibition(int $exgibitionId, int|null $groupId = null): int
    {
        $query = self::getQueryForExhibition($exgibitionId,$groupId);        
        return $query->count();        
    }
    
    protected static function getQueryForExhibition(int $exgibitionId, int|null $groupId = null) : Query
    {
        return Equipment::find()
                ->joinWith(['equipmentPrices' => function(Query $q) use ($exgibitionId) {
                    $q->andWhere(['exhibition_id' => $exgibitionId]);
                }])->andFilterWhere(['group_id' => $groupId]);        
    }
}
