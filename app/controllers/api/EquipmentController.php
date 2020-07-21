<?php

namespace app\controllers\api;

use app\controllers\JsonController;
use app\core\providers\Data\Nomenclature\EquipmentGroupProvider;
use app\core\providers\Data\Nomenclature\EquipmentProvider;
/**
 * Description of EquipmentController
 *
 * @author kotov
 */
class EquipmentController extends JsonController
{
    /**
     *
     * @var EquipmentGroupProvider
     */
    private $equipmentGroupProvider;
    
    /**
     *
     * @var EquipmentProvider
     */
    private $equipmentProvider;


    public function __construct(
            $id, 
            $module, 
            EquipmentGroupProvider $equipmentGroupProvider,
            EquipmentProvider $equipmentProvider,
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
        $this->equipmentGroupProvider = $equipmentGroupProvider;
        $this->equipmentProvider = $equipmentProvider;
    }
   
        
    
    public function actionGetCategories():array
    {        
        return $this->equipmentGroupProvider->getList();
    }
    
    public function actionGetEquipments(int $categoryId):array   
    {
        return $this->equipmentProvider->getList($categoryId);
    }
}
