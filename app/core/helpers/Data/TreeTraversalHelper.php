<?php

namespace app\core\helpers\Data;

/**
 * Description of TreeTraversalHelper
 *
 * @author kotov
 */
class TreeTraversalHelper
{
    public static function addAdditionalDataToTree(array &$tree, array $data)
    {
        foreach ($data as $key => $value) {
            $tree[$key] = $value;
        }
        if (!empty($tree['children'])) {
            foreach ($tree['children'] as &$item) {
                self::addAdditionalDataToTree($item, $data);
            }
        }
    }
}
