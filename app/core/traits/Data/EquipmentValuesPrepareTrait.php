<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\core\traits\Data;

use app\core\repositories\manage\Nomenclature\EquipmentRepository;
use app\models\ActiveRecord\Nomenclature\Equipment;

/**
 *
 * @author kotov
 */
trait EquipmentValuesPrepareTrait
{
     private function processEquipmentValues($values)
     {
         /** @var Equipment $equipment */
         $eqRepository = new EquipmentRepository();;
         $resArray = [];
         foreach ($values as $value) {             
             $equipment = $eqRepository->get($value['id']);
             $resArray[$equipment->id] = [
                 'id' => $equipment->id,
                 'name' => $equipment->name,
                 'code' => $equipment->code,
                 'group' => $equipment->equipmentGroup->name,
                 'group_id' => $equipment->equipmentGroup->id,
                 'unit' => $equipment->unit->short_name,
                 'count' => $value['count'],
                 'price' => $value['price'],
             ];
         }
         return $resArray;
     }
}
