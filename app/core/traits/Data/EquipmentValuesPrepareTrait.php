<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\core\traits\Data;

/**
 *
 * @author kotov
 */
trait EquipmentValuesPrepareTrait
{
     private function processEquipmentValues($values)
     {
         /** @var Equipment $equipment */
         $resArray = [];
         foreach ($values as $value) {             
             $equipment = $this->equipmentRepository->get($value['id']);
             $resArray[$equipment->id] = [
                 'id' => $equipment->id,
                 'name' => $equipment->name,
                 'code' => $equipment->code,
                 'unit' => $equipment->unit->short_name,
                 'count' => $value['count'],
                 'price' => $value['price'],
             ];
         }
         return $resArray;
     }
}
