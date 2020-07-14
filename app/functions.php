<?php

use yii\helpers\VarDumper;

/**
 * Обертка для Yii2 VarDumper
 * @param mixed $var Отображаемая переменная
 * @param int $depth Максимальная глубина вложенности при выводе 
 * объекта или массива
 * @param bool $highlight Использовать стилевую подсветку (по умолчанию ДА)
 */
function dump($var,$depth = 15, $highlight = true) 
{
    VarDumper::dump($var,$depth,$highlight);
}

if (!function_exists('mb_str_split')) {
    /**
     * Разбиение строки на массив символов (аналог str_split для многобайтных кодировок)
     * @param type $string
     * @return type
     */
    function mb_str_split( $string ) 
    { 
        return preg_split('/(?<!^)(?!$)/u', $string );
    }
}
/**
 * Форматирует целое число, разделяя разряды чисел пробелами
 * @param type $number
*/
function f($number) 
{
    return Yii::$app->formatter->asInteger($number);
}

