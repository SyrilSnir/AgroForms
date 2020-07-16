<?php

use app\models\ActiveRecord\Forms\ElementType;

return [
    ['id' => ElementType::ELEMENT_CHECKBOX, 'name' => 'Чекбокс'],
    ['id' => ElementType::ELEMENT_SELECT, 'name' => 'Селектор'],
    ['id' => ElementType::ELEMENT_SELECT_MULTIPLE, 'name' => 'Селектор с множественным выбором'],
    ['id' => ElementType::ELEMENT_DATE, 'name' => 'Выбор даты'],
    ['id' => ElementType::ELEMENT_DATE_MULTIPLE, 'name' => 'Выбор нескольких дат'],
    ['id' => ElementType::ELEMENT_RADIO_BUTTON, 'name' => 'Радиокнопка'],
    ['id' => ElementType::ELEMENT_NUMBER_INPUT, 'name' => 'Число'],
    ['id' => ElementType::ELEMENT_CHECK_NUMBER_INPUT, 'name' => 'Число с флажком'],
    ['id' => ElementType::ELEMENT_TEXT_INPUT, 'name' => 'Текстое поле'],
    ['id' => ElementType::ELEMENT_INFORMATION, 'name' => 'Блок "Информация"'],
    ['id' => ElementType::ELEMENT_INFORMATION_IMPORTANT, 'name' => 'Блок "Важно"'],
    ['id' => ElementType::ELEMENT_HEADER, 'name' => 'Блок "Заголовок"'],
];
