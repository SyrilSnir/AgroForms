<?php

namespace app\controllers\api;

use app\controllers\JsonController;
use app\core\providers\Data\Nomenclature\EquipmentGroupProvider;
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
    
    public function __construct(
            $id, 
            $module, 
            EquipmentGroupProvider $equipmentGroupProvider,
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
        $this->equipmentGroupProvider = $equipmentGroupProvider;
    }
   
        
    
    public function actionGetCategories():array
    {        
        return $this->equipmentGroupProvider->getList();
    }
}
