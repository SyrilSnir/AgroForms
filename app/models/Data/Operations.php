<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPInterface.php to edit this template
 */

namespace app\models\Data;

/**
 *
 * @author kotov
 */
interface Operations
{
    /**
     * Просмотр
     */
    const OP_VIEW = 'view';
    
    /**
     * Создание
     */
    const OP_CREATE = 'create';
    /**
     * Просмотр
     */
    const OP_DELETE = 'delete';
    
    /**
     * Создание
     */
    const OP_EDIT = 'edit';
    
    /**
     * Пользователь
     */
    const ENTITY_USER = 'user';
    
    /**
     * Компания
     */
    const ENTITY_COMPANY = 'company';
    
    /**
     * Договор
     */
    const ENTITY_CONTRACT = 'contract';
    
    /**
     * Документ
     */
    const ENTITY_DOCUMENT = 'document';
    
    /**
     * Раздел рубрикатора
     */
    const ENTITY_RUBRICATOR = 'rubricator';
}
