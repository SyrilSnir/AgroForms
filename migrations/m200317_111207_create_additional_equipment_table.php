<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%additional_equipment}}`.
 */
class m200317_111207_create_additional_equipment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%additional_equipment}}', [
            'id' => $this->primaryKey(),
            'group_id' => $this->integer()->comment('Группа оборудования'),
            'code' => $this->string()->comment('Код'),
            'name' => $this->string()->notNull()->comment('Наименование'),
            'description' => $this->text()->comment('Описание'),
            'unit_id' => $this->integer()->notNull()->comment('Единица измерения'),
            'price' => $this->integer()->notNull()->comment('Стоимость')
        ]);
        
        $this->createIndex(
            'idx-additional_equipment-group_id',
            '{{%additional_equipment}}',
            'group_id'
        );
        $this->createIndex(
            'idx-additional_equipment-unit_id',
            '{{%additional_equipment}}',
            'unit_id'
        );
    }        

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-additional_equipment-group_id',
            '{{%additional_equipment}}'
        );
        $this->dropIndex(
            'idx-additional_equipment-unit_id',
            '{{%additional_equipment}}'
        );
        $this->dropTable('{{%additional_equipment}}');
    }
}
